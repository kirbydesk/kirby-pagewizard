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
			const palette = style === 'variant'
				? { ...this.colors.default, ...this.colors.variant }
				: this.colors.default;
			const vars = {};
			for (const [key, value] of Object.entries(palette)) {
				vars['--' + key] = value;
			}
			return vars;
		}
	}
};
