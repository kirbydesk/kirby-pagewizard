export default {
	props: {
		label: String,
		help: String,
	},
	computed: {
		translatedLabel() {
			return this.$t(this.label, this.label);
		},
		dataTheme() {
			return this.$attrs["data-theme"] || null;
		}
	},
	template: `
		<header class="k-headline-field" :data-theme="dataTheme">
			<h2 class="k-headline" v-html="translatedLabel"></h2>
			<footer v-if="help" class="k-field-footer">
				<div class="k-help k-field-help k-text" v-html="help"></div>
			</footer>
		</header>
	`
};
