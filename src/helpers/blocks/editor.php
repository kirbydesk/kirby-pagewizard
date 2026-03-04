<?php

class pwEditor
{
	public static function contentField(array $editorConfig = [], array $settings = []): array
	{
		// Allowed modes: settings['editor'] is either false or an array of mode names
		$allModes    = ['textarea', 'writer', 'markdown'];
		$editorSetting = $settings['editor'] ?? $allModes;
		$writerModes = is_array($editorSetting)
			? array_values(array_intersect($allModes, $editorSetting))
			: $allModes;
		if (empty($writerModes)) $writerModes = $allModes;

		// Writer field options from editor.json (with fallbacks)
		$writerMarks    = $editorConfig['marks']    ?? ['bold', 'italic', 'underline', 'strike', 'link'];
		$writerNodes    = $editorConfig['nodes']    ?? ['heading', 'bulletList', 'orderedList'];
		$writerHeadings = $editorConfig['headings'] ?? [2, 3, 4];
		$writerToolbar  = $editorConfig['toolbar']  ?? ['inline' => false];

		return [
			'type'           => 'pweditor',
			'label'          => 'pw.field.text',
			'writerModes'    => $writerModes,
			'writerMarks'    => $writerMarks,
			'writerNodes'    => $writerNodes,
			'writerHeadings' => $writerHeadings,
			'writerToolbar'  => $writerToolbar,
		];
	}
}
