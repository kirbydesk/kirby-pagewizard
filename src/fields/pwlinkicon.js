// Mirrors the icon-select pattern that works in projectwizard's
// GlobalNavigation.vue (header > desktop > flyout > icon): full <svg>
// strings v-html'd directly onto the button, no wrapping span.
const inlineIcons = {
	'none':       '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="6" y1="12" x2="18" y2="12"/></svg>',
	'arrow':      '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 5l7 7-7 7"/></svg>',
	'long-arrow': '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12h19m-5-5l5 5-5 5"/></svg>',
	'chevron':    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 6 15 12 9 18"/></svg>',
	'caret':      '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5l8 7-8 7z"/></svg>'
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
		return { current: this.value || 'arrow', inlineIcons };
	},
	watch: {
		value(v) { this.current = v || 'arrow'; }
	},
	computed: {
		options() { return options; }
	},
	methods: {
		select(opt) {
			if (this.disabled) return;
			this.current = opt;
			this.$emit('input', opt);
		}
	},
	template: `
		<k-field v-bind="$props">
			<div class="pw-icon-select">
				<button
					v-for="opt in options"
					:key="opt"
					type="button"
					class="pw-icon-option"
					:class="{ 'is-active': current === opt }"
					:disabled="disabled"
					@click="select(opt)"
					v-html="inlineIcons[opt]"
				></button>
			</div>
		</k-field>
	`
};
