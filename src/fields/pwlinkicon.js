// Inline SVG library for the icon-select row in the cardlet item link tab.
// Kept identical to the SVGs the cardlets snippet embeds at render time.
const icons = {
	none:         '<line x1="6" y1="12" x2="18" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>',
	arrow:        '<path d="M5 12h14M13 5l7 7-7 7" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
	'long-arrow': '<path d="M2 12h19m-5-5l5 5-5 5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
	chevron:      '<polyline points="9 6 15 12 9 18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
	caret:        '<path d="M8 5l8 7-8 7z" fill="currentColor"/>'
};

const options = ['none', 'arrow', 'long-arrow', 'chevron', 'caret'];

export default {
	props: {
		value:    String,
		label:    String,
		help:     String,
		required: Boolean,
		disabled: Boolean
	},
	data() {
		return { current: this.value || 'arrow' };
	},
	watch: {
		value(v) { this.current = v || 'arrow'; }
	},
	methods: {
		select(opt) {
			if (this.disabled) return;
			this.current = opt;
			this.$emit('input', opt);
		},
		iconHtml(key) {
			return '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">' + (icons[key] || '') + '</svg>';
		},
		isActive(opt) {
			return this.current === opt;
		},
		allOptions() {
			return options;
		}
	},
	template: `
		<k-field v-bind="$props" class="pw-link-icon-field">
			<div class="pw-link-icon-row">
				<button
					v-for="opt in allOptions()"
					:key="opt"
					type="button"
					class="pw-link-icon-option"
					:class="{ 'is-active': isActive(opt) }"
					:disabled="disabled"
					@click="select(opt)"
				><span v-html="iconHtml(opt)"></span></button>
			</div>
		</k-field>
	`
};
