export default {
	props: {
		value: String,
		align: { type: String, default: 'left' },
		alwaysVisible: { type: Boolean, default: false }
	},
	data() {
		return {
			current: this.value || this.align,
			show: false,
			btnEl: null,
			dropdownEl: null,
			container: null,
			_closeHandler: null,
			_observer: null,
			_nextColumn: null,
		}
	},
	watch: {
		value(v) {
			this.current = v || this.align;
			this.updateIcon();
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

			this.btnEl = document.createElement('button');
			this.btnEl.type = 'button';
			this.btnEl.className = 'input-focus k-button';
			this.btnEl.setAttribute('data-has-icon', 'true');
			this.btnEl.setAttribute('data-has-text', 'false');
			this.btnEl.setAttribute('data-size', 'xs');
			this.btnEl.setAttribute('data-variant', 'filled');
			this.btnEl.setAttribute('aria-label', 'Align');
			this.updateIcon();
			this.container.appendChild(this.btnEl);

			this.btnEl.addEventListener('click', (e) => {
				e.stopPropagation();
				this.toggleDropdown();
			});

			this._closeHandler = (e) => {
				if (!this.container.contains(e.target)) {
					this.closeDropdown();
				}
			};
			document.addEventListener('click', this._closeHandler);

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
		updateIcon() {
			if (!this.btnEl) return;
			const icon = this.current || 'left';
			this.btnEl.innerHTML = '<span class="k-button-icon"><svg class="k-icon"><use xlink:href="#icon-text-' + icon + '"></use></svg></span>';
		},
		toggleDropdown() {
			if (this.show) {
				this.closeDropdown();
			} else {
				this.showDropdown();
			}
		},
		showDropdown() {
			if (this.dropdownEl) this.dropdownEl.remove();

			this.dropdownEl = document.createElement('dialog');
			this.dropdownEl.className = 'k-dropdown-content pw-dropdown';
			this.dropdownEl.setAttribute('data-theme', 'dark');
			this.dropdownEl.setAttribute('open', '');

			const navEl = document.createElement('div');
			navEl.className = 'k-navigate';

			['left', 'center', 'right'].forEach((opt) => {
				const btn = document.createElement('button');
				btn.type = 'button';
				btn.className = 'k-button k-dropdown-item';
				btn.setAttribute('data-has-icon', 'true');
				btn.innerHTML = '<span class="k-button-icon"><svg class="k-icon"><use xlink:href="#icon-text-' + opt + '"></use></svg></span>';
				btn.addEventListener('click', (e) => {
					e.stopPropagation();
					this.select(opt);
				});
				navEl.appendChild(btn);
			});

			this.dropdownEl.appendChild(navEl);
			this.container.appendChild(this.dropdownEl);
			this.show = true;
		},
		closeDropdown() {
			if (this.dropdownEl) {
				this.dropdownEl.remove();
				this.dropdownEl = null;
			}
			this.show = false;
		},
		select(opt) {
			this.current = opt;
			this.updateIcon();
			this.closeDropdown();
			this.$emit('input', opt);
		}
	},
	beforeDestroy() {
		if (this._observer) this._observer.disconnect();
		if (this.container) this.container.remove();
		if (this._closeHandler) document.removeEventListener('click', this._closeHandler);
	},
	template: '<div style="display:none"></div>'
};
