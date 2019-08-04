<?php

namespace Foundry\Requests\Types;



/**
 * Class EditorInputType
 *
 * @package Foundry\Requests\Types
 */
class HtmlEditorInputType extends TextInputType {

	protected $toolbar = [
		['style', ['style']],
		['font', ['bold', 'underline', 'clear']],
		['fontname', ['fontname']],
		['color', ['color']],
		['para', ['ul', 'ol', 'paragraph']],
		['table', ['table']],
		['insert', ['link']],
	];

    public function __construct(
        string $name,
        string $label = null,
        bool $required = true,
        string $value = null,
        string $position = 'full',
        string $rules = null,
        string $id = null,
        string $placeholder = null
    ) {
        $type = 'html-editor';
        parent::__construct( $name, $label, $required, $value, $position, $rules, $id, $placeholder, $type );
    }

    public function setToolbar(array $toolbar)
    {
    	$this->toolbar = $toolbar;
    	return $this;
    }

    public function setSimpleToolbar()
    {
    	$this->toolbar = [
		    ['font', ['bold', 'underline', 'clear']],
		    ['color', ['color']],
		    ['para', ['ul', 'ol', 'paragraph']],
		    ['insert', ['link']],
	    ];

    	return $this;
    }

}
