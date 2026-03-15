<?php

namespace App\Exports;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class BaseExport implements FromCollection, WithHeadings, Responsable , WithStyles , ShouldAutoSize
{
    use Exportable;

    public string $fileName = 'export.xlsx';

    protected array $columns = [];
    protected Collection $collection;

    protected bool $extractTranslations = true;

    /**
     * __construct
     *
     * @param  mixed $collection
     * @param  mixed $fileName
     * @return void
     */
    public function __construct($collection, string $fileName = null)
    {
        $this->collection = collect($collection);

        if ($fileName) {
            $this->fileName = $fileName;
        }
    }

    /**
     * withColumns
     *
     * @param  mixed $columns
     * @return static
     */
    public function withColumns(array $columns): static
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * withoutTranslationExtraction
     *
     * @return static
     */
    public function withoutTranslationExtraction(): static
    {
        $this->extractTranslations = false;
        return $this;
    }

    /**
     * collection
     *
     * @return void
     */
    public function collection()
    {
        return $this->collection->map(function ($item) {
            $row = [];

            $array = $item instanceof \JsonSerializable
                ? $item->jsonSerialize()
                : (array) $item;

            $this->_flattenWithTranslation($array, $row);

            return $row;
        });
    }

    /**
     * _flattenWithTranslation
     *
     * @param  mixed $data
     * @param  mixed $output
     * @param  mixed $prefix
     * @return void
     */
    protected function _flattenWithTranslation(array $data, array &$output, string $prefix = '')
    {
        foreach ($data as $key => $value) {
            $fullKey = $prefix ? "{$prefix}.{$key}" : $key;

            // Convert stdClass to array if it exists
            if (is_object($value)) {
                $value = json_decode(json_encode($value), true);
            }
            //  Subtitle support (en/ar contain internal arrays)

            if ($this->extractTranslations && $this->_isDeepTranslatableArray($value)) {
                foreach ($value as $lang => $translations) {
                    if (is_array($translations)) {
                        foreach ($translations as $subKey => $subValue) {
                            $output["{$fullKey}.{$subKey}({$lang})"] = $subValue;
                        }
                    }
                }
                continue;
            }

            // Simple translation support {"en": "...", "ar": "..."}
            if ($this->extractTranslations && $this->_isTranslatableArray($value)) {
                $output["{$fullKey}(en)"] = $value['en'] ?? null;
                $output["{$fullKey}(ar)"] = $value['ar'] ?? null;
                continue;
            }

            if (is_array($value)) {
                $this->_flattenWithTranslation($value, $output, $fullKey);
            } else {
                $output[$fullKey] = $value;
            }
        }
    }

    /**
     * headings
     *
     * @return array
     */
    public function headings(): array
    {
        return $this->columns ?: array_keys($this->collection()->first() ?? []);
    }
 /**
     * Apply styles to the Excel sheet (header row).
     */
    public function styles(Worksheet $sheet): array
    {
        $headings = $this->headings();
        $columnCount = count($headings);
        $lastColumn = Coordinate::stringFromColumnIndex($columnCount);

        $sheet->getStyle("A1:{$lastColumn}1")->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '000000'],
            ],
        ]);

        return [];
    }

    /**
     * isJson
     *
     * @param  mixed $string
     * @return bool
     */
    protected function _isJson($string): bool
    {
        if (!is_string($string)) {
            return false;
        }

        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * isTranslatableArray
     *
     * @param  mixed $value
     * @return bool
     */
    protected function _isTranslatableArray($value): bool
    {
        return is_array($value)
            && (array_key_exists('en', $value) || array_key_exists('ar', $value));
    }
    /**
     * _isDeepTranslatableArray
     *
     * @param  mixed $value
     * @return bool
     */
    protected function _isDeepTranslatableArray($value): bool
    {
        return is_array($value)
            && array_key_exists('en', $value)
            && array_key_exists('ar', $value)
            && is_array($value['en']) && is_array($value['ar']);
    }
}
