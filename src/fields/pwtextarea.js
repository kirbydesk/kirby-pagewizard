export default {
	extends: 'k-textarea-field',
	props: {
		label: String,
		help: String,
		placeholder: String,
		value: String,
		align: String,
		alignOptions: {
			type: Array,
			default: () => ['left', 'center', 'right']
		}
	},
	data() {
		return {
			currentAlign: this.parseValue().align || (this.align || 'left'),
			showAlignDropdown: false
		}
	},
	watch: {
		value() {
			const parsed = this.parseValue();
			if (parsed.align) this.currentAlign = parsed.align;
		}
	},
	methods: {
		parseValue() {
			if (!this.value) return {};
			try {
				return typeof this.value === 'string' ? JSON.parse(this.value) : this.value;
			} catch(e) {
				return { text: this.value };
			}
		},
		emitValue(text, align) {
			this.$emit('input', JSON.stringify({ text, align }));
		},
		updateAlign(value) {
			this.currentAlign = value;
			this.showAlignDropdown = false;
			const parsed = this.parseValue();
			this.emitValue(parsed.text || '', value);
		},
		handleInput(event) {
			this.autoResize(event.target);
			this.emitValue(event.target.value, this.currentAlign);
		},
		autoResize(textarea) {
			textarea.style.height = 'auto';
			const h = textarea.scrollHeight;
			textarea.style.height = h + 'px';
			textarea.style.minHeight = h + 'px';
		},
		toggleAlignDropdown() {
			this.showAlignDropdown = !this.showAlignDropdown;
		},
		handleClickOutside(event) {
			if (!this.$el.contains(event.target)) {
				this.showAlignDropdown = false;
			}
		},
		handleEscape(event) {
			if (event.key === 'Escape' && this.showAlignDropdown) {
				event.stopPropagation();
				event.preventDefault();
				this.showAlignDropdown = false;
			}
		}
	},
	mounted() {
		this.$nextTick(() => {
			document.addEventListener('click', this.handleClickOutside, true);
			document.addEventListener('keydown', this.handleEscape);
			const textarea = this.$el.querySelector('textarea');
			if (textarea) this.autoResize(textarea);
		});
	},
	beforeDestroy() {
		document.removeEventListener('click', this.handleClickOutside, true);
		document.removeEventListener('keydown', this.handleEscape);
	},
	template: `
		<div class="k-field k-textarea-field pw-textarea-field" :data-align="currentAlign">
			<header v-if="label" class="k-field-header">
				<label class="k-label k-field-label">
					<span class="k-label-text">{{ label }}</span>
				</label>
			</header>
			<div class="k-input" data-type="textarea">
				<span class="k-input-element">
					<textarea
						:value="parseValue().text || ''"
						@input="handleInput"
						:placeholder="placeholder"
						class="k-string-input k-textarea-input pw-textarea"
					></textarea>
				</span>
			</div>
			<span class="k-input-icon pw-textarea-icon" @click.stop="toggleAlignDropdown">
				<svg aria-hidden="true" :data-type="'text-' + currentAlign" class="k-icon">
					<use :xlink:href="'#icon-text-' + currentAlign"></use>
				</svg>
				<dialog v-if="showAlignDropdown" class="k-dropdown-content pw-dropdown" data-theme="dark" open>
					<div class="k-navigate">
						<button
							v-for="option in alignOptions"
							:key="option"
							@click.stop="updateAlign(option)"
							type="button"
							class="k-button k-dropdown-item"
							data-has-icon="true"
						>
							<span class="k-button-icon">
								<svg class="k-icon"><use :xlink:href="'#icon-text-' + option"></use></svg>
							</span>
						</button>
					</div>
				</dialog>
			</span>
			<footer v-if="help" class="k-field-footer">
				<div class="k-help k-field-help k-text" v-html="help"></div>
			</footer>
		</div>
	`
};
