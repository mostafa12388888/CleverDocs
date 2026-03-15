<?php
namespace App\Enum\Form;

use App\Enum\Enum;

class InputTypeEnum extends Enum
{
    const DATE = 'date';
    const DATETIME = 'date_time';
    const MULTIPLE_DATE= 'multiple_dates';
    const TIME='time';
    const DATE_RANGE = 'date_range';
    const INPUT= 'input';
    const REFERENCE= 'reference';
    const EMAIL = 'email';
    const URL = 'url';
    const DROPDOWN = 'dropdown';
    const TEXT_AREA = 'text_area';
    const TEXT_EDITOR= 'text_editor';
    const FILE_UPLOAD = 'file_upload';
    const BUILT_IN_ATTACHMENT = 'built_in_attachments';
    const CREATE_NEW_VERSION = 'create_new_version';
    const IMAGE_HEADER='image_header';
    const IMAGE_FOOTER='image_footer';
    const OFFICIAL_SIGNATURE='official_signature';
    const NUMBER_INPUT= 'number_input';
    const SERIAL_NUMBER= 'serial_number';
    const PHONE= 'phone';
    const CHECKBOX = 'checkboxes';
    const RADIO= 'radio';
    const TOGGLE= 'toggle';
    const DIVIDER= 'divider';
    const SHAPES= 'shapes';
    const CURRENCY= 'currency';
    const SINGLE_CHECKBOX= 'single_checkbox';
    const FILE = 'file';
    const SELECT = 'select';
    const TABLE = 'table';
}
