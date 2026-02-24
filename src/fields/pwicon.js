export default {
	props: {
		value:    String,
		label:    String,
		help:     String,
		disabled: Boolean,
	},
	data() {
		return {
			current: this.value || '',
			icons:   [],
			search:  '',
			setName: '',
		};
	},
	watch: {
		value(v) {
			this.current = v || '';
		}
	},
	computed: {
		filtered() {
			const q = this.search.trim().toLowerCase();
			if (!q) return [];
			return this.icons.filter(i => i.id.toLowerCase().includes(q));
		},
		selectedIcon() {
			if (!this.current) return null;
			return this.icons.find(i => i.svg === this.current) || null;
		},
		showCount() {
			return this.search.trim() ? this.filtered.length : this.icons.length;
		},
	},
	async created() {
		try {
			const config = await this.$api.get('pagewizard/config');
			const activeSet = config['icon-set'];
			this.setName = config['icon-set-name'] || activeSet;
			const res = await this.$api.get('pagewizard/icons/' + activeSet);
			this.icons = Array.isArray(res) ? res : [];
		} catch(e) {
			this.icons = [];
		}
	},
	methods: {
		select(icon) {
			if (this.disabled) return;
			this.current = icon ? icon.svg : '';
			this.$emit('input', this.current);
		},
		clear() {
			if (this.disabled) return;
			this.current = '';
			this.$emit('input', '');
		},
		isActive(icon) {
			return this.current === icon.svg;
		},
	},
	template: `
		<k-field v-bind="$props" class="pw-icon-field">
			<div class="pw-icon-search">
				<div class="pw-icon-input-wrap">
					<k-input
						type="text"
						:placeholder="$t('pw.field.icon.placeholder')"
						:value="search"
						@input="search = $event"
					/>
					<span class="pw-icon-count">{{ showCount }}</span>
				</div>
				<button
					v-if="current"
					type="button"
					class="pw-icon-preview"
					:title="selectedIcon ? selectedIcon.label : ''"
					:disabled="disabled"
					@click="clear()"
				><span v-html="current"></span></button>
			</div>
			<div class="k-help k-field-help k-text" style="margin-top: var(--spacing-2); margin-bottom: var(--spacing-8)"><p v-html="$t('pw.field.icon.help', { total: icons.length, set: setName })"></p></div>
			<div class="pw-icon-grid">
				<button
					v-for="icon in filtered"
					:key="icon.id"
					type="button"
					class="pw-icon-btn"
					:class="{ 'is-active': isActive(icon), 'is-custom': icon.custom }"
					:disabled="disabled"
					:title="icon.label"
					@click="select(icon)"
				><span v-html="icon.svg"></span></button>
			</div>
		</k-field>
	`
};
