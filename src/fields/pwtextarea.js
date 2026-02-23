export default {
	props: {
		value:        String,
		label:        String,
		help:         String,
		placeholder:  String,
		align:        { type: String, default: 'left' },
		alignOptions: {
			type: Array,
			default: () => ['left', 'center', 'right']
		}
	},
	data() {
		return {
			current:           this.parse(this.value),
			showAlignDropdown: false,
			_closeHandler:     null,
		};
	},
	watch: {
		value(v) {
			this.current = this.parse(v);
		}
	},
	methods: {
		parse(val) {
			if (!val) return { text: '', align: this.align };
			try {
				const d = JSON.parse(val);
				return { text: d.text || '', align: d.align || this.align };
			} catch(e) {
				return { text: val, align: 'left' };
			}
		},
		emit() {
			this.$emit('input', JSON.stringify({ text: this.current.text, align: this.current.align }));
		},
		onInput(e) {
			this.current.text = e.target.value;
			this.autoResize(e.target);
			this.emit();
		},
		setAlign(align) {
			this.current.align = align;
			this.showAlignDropdown = false;
			this.emit();
		},
		toggleAlignDropdown() {
			this.showAlignDropdown = !this.showAlignDropdown;
		},
		autoResize(el) {
			el.style.height = 'auto';
			el.style.height = el.scrollHeight + 'px';
		},
		handleClose(e) {
			if (!this.$el.contains(e.target)) {
				this.showAlignDropdown = false;
			}
		}
	},
	mounted() {
		this._closeHandler = this.handleClose;
		document.addEventListener('click', this._closeHandler, true);
		this.$nextTick(() => {
			const ta = this.$el.querySelector('textarea');
			if (ta) this.autoResize(ta);
		});
	},
	beforeDestroy() {
		document.removeEventListener('click', this._closeHandler, true);
	},
	template: `
		<div class="k-field pw-textarea-field">
			<header class="k-field-header" style="display:flex;align-items:center;overflow:visible;">
				<label v-if="label" class="k-label k-field-label" style="flex:1;">
					<span class="k-label-text">{{ label }}</span>
				</label>
				<span v-else style="flex:1;"></span>
				<div class="k-button-group">
					<span style="position:relative;">
						<button
							data-has-icon="true"
							data-has-text="false"
							aria-label="Align"
							data-size="xs"
							data-variant="filled"
							type="button"
							class="input-focus k-button"
							@click.stop="toggleAlignDropdown"
						><span class="k-button-icon">
							<svg aria-hidden="true" class="k-icon">
								<use :xlink:href="'#icon-text-' + current.align"></use>
							</svg>
						</span></button>
						<dialog v-if="showAlignDropdown" class="k-dropdown-content pw-dropdown" data-theme="dark" open>
							<div class="k-navigate">
								<button
									v-for="opt in alignOptions"
									:key="opt"
									type="button"
									class="k-button k-dropdown-item"
									data-has-icon="true"
									@click.stop="setAlign(opt)"
								>
									<span class="k-button-icon">
										<svg class="k-icon"><use :xlink:href="'#icon-text-' + opt"></use></svg>
									</span>
								</button>
							</div>
						</dialog>
					</span>
				</div>
			</header>
			<div class="k-input pw-textarea-field" data-type="textarea">
				<span class="k-input-element">
					<textarea
						:value="current.text"
						:placeholder="placeholder"
						class="k-string-input k-textarea-input pw-textarea"
						@input="onInput"
					></textarea>
				</span>
			</div>
			<footer v-if="help" class="k-field-footer">
				<div class="k-help k-field-help k-text" v-html="help"></div>
			</footer>
		</div>
	`
};
