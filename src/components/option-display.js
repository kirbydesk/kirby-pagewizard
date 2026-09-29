// How an option of a content field looks (level, size, alignment, text
// marking, multiline, flourish, editor mode): an icon or its text. Shared by
// the field dropdowns and the Project Wizard's restrictions.

// own icons (text marking, multiline, flourish) per value
const PATHS = {
	textbackground: {
		disabled: '<path d="M9 4.9967V11.2694H7V4.9967H5V13.9967H19V4.9967H9ZM20 15.9967H4V17.9967H20V15.9967ZM3 13.9967V3.9967C3 3.44442 3.44772 2.9967 4 2.9967H20C20.5523 2.9967 21 3.44442 21 3.9967V13.9967H22V18.9967C22 19.549 21.5523 19.9967 21 19.9967H13V22.9967H11V19.9967H3C2.44772 19.9967 2 19.549 2 18.9967V13.9967H3Z"/>',
		enabled: '<path d="M20 15.9967H4V17.9967H20V15.9967ZM3 13.9967V3.9967C3 3.44442 3.44772 2.9967 4 2.9967H7V11.2694H9V2.9967H20C20.5523 2.9967 21 3.44442 21 3.9967V13.9967H22V18.9967C22 19.549 21.5523 19.9967 21 19.9967H13V22.9967H11V19.9967H3C2.44772 19.9967 2 19.549 2 18.9967V13.9967H3Z"/>',
	},
	multiline: {
		disabled: '<path d="M5 19H19V5H5V19ZM3 4C3 3.44772 3.44772 3 4 3H20C20.5523 3 21 3.44772 21 4V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V4ZM10 8V11H14V8L18 12L14 16V13H10V16L6 12L10 8Z"/>',
		enabled: '<path d="M5 19H19V5H5V19ZM3 4C3 3.44772 3.44772 3 4 3H20C20.5523 3 21 3.44772 21 4V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V4ZM8 10L12 6L16 10H13V14H16L12 18L8 14H11V10L8 10Z"/>',
	},
	flourish: {
		disabled: '<path d="M5.55397 22H3.3999L10.9999 3H12.9999L20.5999 22H18.4458L16.0458 16H7.95397L5.55397 22ZM8.75397 14H15.2458L11.9999 5.88517L8.75397 14Z"/>',
		enabled: '<path d="M15.2459 14H8.75407L7.15407 18H5L11 3H13L19 18H16.8459L15.2459 14ZM14.4459 12L12 5.88516L9.55407 12H14.4459ZM3 20H21V22H3V20Z"/>',
	},
};

// size and editor mode show their text, the others an icon (an alignment
// without a value its "···")
export function hasIcon(type, value) {
	if (type === 'size' || type === 'mode') return false;
	if (type === 'align') return !!value;
	return ['level', 'textbackground', 'multiline', 'flourish'].includes(type);
}

// the icon's svg content
export function iconHtml(type, value) {
	if (PATHS[type]) return PATHS[type][value] || PATHS[type].disabled;
	// Kirby's sprite: text-left …, h1 …; "div" (no heading element) its own
	const name = type === 'align' ? 'text-' + value : (value === 'div' ? 'pw-level-div' : value);
	return '<use href="#icon-' + name + '"></use>';
}

// the text (t: the panel's translate function); the size steps of texts
// (their scale starts at "normal") are named apart from the headings' (the
// same step is smaller there: "lg" of a text is not "lg" of a heading)
export function optionText(type, value, t, options) {
	if (type === 'mode') return t('pw.field.text-' + value, value);
	if (type === 'align' && !value) return '···';
	if (type === 'size' && Array.isArray(options) && options.includes('normal')) return t('pw.option.text-' + value, value);
	return t('pw.option.' + value, value);
}
