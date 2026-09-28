import pwFieldToolbar from '@/components/field-toolbar.vue';

// The alignment of the field in the next column (media, buttons): this
// field stays invisible, its dropdown – the content fields' shared one, with
// Kirby's arrow – sits in the header of that next field.
export default {
	props: {
		value: String,
		align: { type: String, default: 'left' },
		alignOptions: { type: Array, default: () => ['left', 'center', 'right'] },
		alwaysVisible: { type: Boolean, default: false }
	},
	data() {
		return {
			current: this.value || this.align,
			toolbar: null,
			container: null,
			_observer: null,
			_nextColumn: null,
		}
	},
	watch: {
		value(v) {
			this.current = v || this.align;
			if (this.toolbar) this.toolbar.items = this.toolbarItems();
		}
	},
	mounted() {
		if (!this.value && this.current) {
			this.$emit('input', this.current);
		}
		this.$nextTick(() => {
			const wrapper = this.$el.closest('.k-column');
			if (wrapper) wrapper.style.display = 'none';

			const nextColumn = wrapper?.nextElementSibling;
			const header = nextColumn?.querySelector('.k-field-header');
			if (!header) return;

			this.container = document.createElement('span');
			this.container.className = 'pw-align-btn';
			this.container.style.cssText = 'position:relative;display:flex;align-items:center;';

			// the shared dropdown, mounted into the other field's header
			const Vue = this.$options._base;
			const self = this;
			this.toolbar = new Vue({
				parent: this,
				data: { items: this.toolbarItems() },
				render(h) {
					return h(pwFieldToolbar, {
						props: { items: this.items },
						on: { input: ({ value }) => self.select(value) },
					});
				},
			}).$mount();
			this.container.appendChild(this.toolbar.$el);

			// Insert inside the same action group as the Add/options buttons
			const existingBtn = header.querySelector('.k-button');
			if (existingBtn && existingBtn.parentElement !== header) {
				existingBtn.parentElement.prepend(this.container);
			} else if (existingBtn) {
				header.insertBefore(this.container, existingBtn);
			} else {
				header.appendChild(this.container);
			}

			// Show button only when ≥1 item exists; observe for changes
			this._nextColumn = nextColumn;
			this.updateVisibility();
			this._observer = new MutationObserver(() => this.updateVisibility());
			this._observer.observe(nextColumn, { childList: true, subtree: true });
		});
	},
	methods: {
		updateVisibility() {
			if (!this.container || !this._nextColumn) return;
			if (this.alwaysVisible) {
				this.container.style.display = 'flex';
				return;
			}
			const hasItems = this._nextColumn.querySelector('.k-item, .k-block, .k-structure-item') !== null;
			this.container.style.display = hasItems ? 'flex' : 'none';
		},
		toolbarItems() {
			return [{ key: 'align', value: this.current || 'left', options: this.alignOptions }];
		},
		select(opt) {
			this.current = opt;
			if (this.toolbar) this.toolbar.items = this.toolbarItems();
			this.$emit('input', opt);
		}
	},
	beforeDestroy() {
		if (this._observer) this._observer.disconnect();
		if (this.toolbar) this.toolbar.$destroy();
		if (this.container) this.container.remove();
	},
	template: '<div style="display:none"></div>'
};
