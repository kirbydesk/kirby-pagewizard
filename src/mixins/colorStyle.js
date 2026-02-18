export default {
	data() {
		return {
			colors: null
		}
	},
	async created() {
		try {
			this.colors = await this.$api.get('pagewizard/colors');
		} catch (e) {
			this.colors = null;
		}
	},
	computed: {
		colorVars() {
			if (!this.colors) return {};
			const style = this.content.style || 'default';
			const vars = {};

			if (style === 'custom') {
				// Start with default colors as base
				for (const [key, value] of Object.entries(this.colors.default)) {
					vars['--' + key] = value;
				}
				// Override with user-defined custom colors
				if (this.content.textcolor) {
					vars['--pw-color-text'] = this.content.textcolor;
					vars['--pw-color-heading'] = this.content.textcolor;
					vars['--pw-color-tagline'] = this.content.textcolor;
					vars['--pw-color-link'] = this.content.textcolor;
					vars['--pw-color-quote'] = this.content.textcolor;
					vars['--pw-color-cite'] = this.content.textcolor;
				}
				if (this.content.backgroundcolor) {
					vars['--pw-color-block-background'] = this.content.backgroundcolor;
				}
				// Button style: use default or variant button colors
				const btnStyle = this.content.buttonstyle || 'default';
				if (btnStyle === 'variant' && this.colors.variant) {
					const btnKeys = Object.keys(this.colors.variant).filter(k => k.startsWith('pw-color-button'));
					for (const key of btnKeys) {
						vars['--' + key] = this.colors.variant[key];
					}
				}
			} else {
				const palette = style === 'variant'
					? { ...this.colors.default, ...this.colors.variant }
					: this.colors.default;
				for (const [key, value] of Object.entries(palette)) {
					vars['--' + key] = value;
				}
			}

			return vars;
		}
	}
};
