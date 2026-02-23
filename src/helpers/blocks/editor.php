<?php

class pwEditor
{
	public static function contentField(array $defaults, array $editorConfig = [], array $settings = [], array $fields = []): array
	{
		// Allowed modes: settings['editor'] is either false or an array of mode names
		$allModes    = ['textarea', 'writer', 'markdown'];
		$editorSetting = $settings['editor'] ?? $allModes;
		$writerModes = is_array($editorSetting)
			? array_values(array_intersect($allModes, $editorSetting))
			: $allModes;
		if (empty($writerModes)) $writerModes = $allModes;

		// Default mode from editor.json (falls back to first allowed mode)
		$defaultMode = $editorConfig['default-mode'] ?? ($writerModes[0] ?? 'textarea');
		if (!in_array($defaultMode, $writerModes, true)) {
			$defaultMode = $writerModes[0] ?? 'textarea';
		}

		// Writer field options from editor.json (with fallbacks)
		$writerMarks    = $editorConfig['marks']    ?? ['bold', 'italic', 'underline', 'strike', 'link'];
		$writerNodes    = $editorConfig['nodes']    ?? ['heading', 'bulletList', 'orderedList'];
		$writerHeadings = $editorConfig['headings'] ?? [2, 3, 4];
		$writerToolbar  = $editorConfig['toolbar']  ?? ['inline' => false];

		$defaultAlign = $fields['align-editor'] ?? 'left';

		return [
			'type'         => 'pweditor',
			'label'        => 'pw.field.text',
			'align'        => $defaultAlign,
			'writerModes'  => $writerModes,
			'writerMarks'    => $writerMarks,
			'writerNodes'    => $writerNodes,
			'writerHeadings' => $writerHeadings,
			'writerToolbar'  => $writerToolbar,
		];
	}
}
