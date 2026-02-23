export default {
	props: {
		value:   String,
		label:   String,
		help:    String,
		disabled: Boolean,
	},
	data() {
		return {
			current: this.value || '',
			icons:   [],
		};
	},
	watch: {
		value(v) {
			this.current = v || '';
		}
	},
	async created() {
		try {
			const res = await this.$api.get('pagewizard/icons');
			this.icons = Array.isArray(res) ? res : [];
		} catch(e) {
			this.icons = [];
		}
	},
	methods: {
		select(id) {
			if (this.disabled) return;
			this.current = id;
			this.$emit('input', id);
		}
	},
	template: `
		<k-field v-bind="$props" class="pw-icon-field">
			<div class="pw-icon-grid">
				<button
					type="button"
					class="pw-icon-btn pw-icon-none"
					:class="{ 'is-active': !current }"
					:disabled="disabled"
					title="None"
					@click="select('')"
				>–</button>
				<button
					v-for="icon in icons"
					:key="icon.id"
					type="button"
					class="pw-icon-btn"
					:class="{ 'is-active': current === icon.id }"
					:disabled="disabled"
					:title="icon.label"
					@click="select(icon.id)"
				><span v-html="icon.svg"></span></button>
			</div>
		</k-field>
	`
};
