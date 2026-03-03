export default {
	extends: 'k-text-field',
	props: {
		label: String,
		help: String,
		placeholder: String,
		value: String,
		align: String,
		level: String,
		size: String,
		alignOptions: {
			type: Array,
			default: () => ['left', 'center', 'right']
		},
		levelOptions: {
			type: Array,
			default: () => ['h1', 'h2', 'h3', 'h4']
		},
		sizeOptions: {
			type: Array,
			default: () => ['xs', 'sm', 'md', 'lg', 'xl', '2xl', '3xl']
		}
	},
	data() {
		return {
			currentAlign: this.parseValue().align || (this.align || 'left'),
			currentLevel: this.parseValue().level || (this.level || 'h2'),
			currentSize: this.parseValue().size || this.size || '2xl',
			showAlignDropdown: false,
			showLevelDropdown: false,
			showSizeDropdown: false
		}
	},
	watch: {
		value(newValue) {
			const parsed = this.parseValue();
			if (parsed.align) this.currentAlign = parsed.align;
			if (parsed.level) this.currentLevel = parsed.level;
			if (parsed.size) this.currentSize = parsed.size;
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
		emitValue(text, align, level, size) {
			this.$emit('input', JSON.stringify({ text, align, level, size }));
		},
		updateAlign(value) {
			this.currentAlign = value;
			this.showAlignDropdown = false;
			const parsed = this.parseValue();
			this.emitValue(parsed.text || '', value, parsed.level || this.currentLevel, parsed.size || this.currentSize);
		},
		updateLevel(value) {
			this.currentLevel = value;
			this.showLevelDropdown = false;
			const parsed = this.parseValue();
			this.emitValue(parsed.text || '', parsed.align || this.currentAlign, value, parsed.size || this.currentSize);
		},
		updateSize(value) {
			this.currentSize = value;
			this.showSizeDropdown = false;
			const parsed = this.parseValue();
			this.emitValue(parsed.text || '', parsed.align || this.currentAlign, parsed.level || this.currentLevel, value);
		},
		handleInput(event) {
			this.emitValue(event.target.value, this.currentAlign, this.currentLevel, this.currentSize);
		},
		closeDropdowns() {
			this.showAlignDropdown = false;
			this.showLevelDropdown = false;
			this.showSizeDropdown = false;
		},
		toggleLevelDropdown() {
			this.showAlignDropdown = false;
			this.showSizeDropdown = false;
			this.showLevelDropdown = !this.showLevelDropdown;
		},
		toggleAlignDropdown() {
			this.showLevelDropdown = false;
			this.showSizeDropdown = false;
			this.showAlignDropdown = !this.showAlignDropdown;
		},
		toggleSizeDropdown() {
			this.showAlignDropdown = false;
			this.showLevelDropdown = false;
			this.showSizeDropdown = !this.showSizeDropdown;
		},
		handleClickOutside(event) {
			if (!this.$el.contains(event.target)) {
				this.closeDropdowns();
			}
		},
		handleEscape(event) {
			if (event.key === 'Escape' && (this.showAlignDropdown || this.showLevelDropdown || this.showSizeDropdown)) {
				event.stopPropagation();
				event.preventDefault();
				this.closeDropdowns();
			}
		},
		sizeLabel(size) {
			return (size || 'md').toUpperCase();
		}
	},
	mounted() {
		this.$nextTick(() => {
			document.addEventListener('click', this.handleClickOutside, true);
			document.addEventListener('keydown', this.handleEscape);
		});
	},
	beforeDestroy() {
		document.removeEventListener('click', this.handleClickOutside, true);
		document.removeEventListener('keydown', this.handleEscape);
	},
	template: `
		<div class="k-field k-text-field" :data-align="currentAlign" :data-level="currentLevel" :data-size="currentSize">
			<header class="k-field-header" style="display:flex;align-items:center;overflow:visible;">
				<label v-if="label" class="k-label k-field-label" style="flex:1;">
					<span class="k-label-text">{{ label }}</span>
				</label>
				<span v-else style="flex:1;"></span>
				<div v-if="align || level || size" class="k-button-group">
					<span v-if="align" style="position:relative;">
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
								<use :xlink:href="'#icon-text-' + currentAlign"></use>
							</svg>
						</span></button>
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
					<span v-if="size" style="position:relative;">
						<button
							data-has-icon="false"
							data-has-text="true"
							aria-label="Size"
							data-size="xs"
							data-variant="filled"
							type="button"
							class="input-focus k-button"
							@click.stop="toggleSizeDropdown"
						><span class="k-button-text pw-size-label">{{ sizeLabel(currentSize) }}</span></button>
						<dialog v-if="showSizeDropdown" class="k-dropdown-content pw-dropdown" data-theme="dark" open>
							<div class="k-navigate">
								<button
									v-for="option in sizeOptions"
									:key="option"
									@click.stop="updateSize(option)"
									type="button"
									class="k-button k-dropdown-item"
									data-has-text="true"
									data-has-icon="false"
								>
									<span class="k-button-text pw-size-label">{{ sizeLabel(option) }}</span>
								</button>
							</div>
						</dialog>
					</span>
					<span v-if="level" style="position:relative;">
						<button
							data-has-icon="true"
							data-has-text="false"
							aria-label="Level"
							data-size="xs"
							data-variant="filled"
							type="button"
							class="input-focus k-button"
							@click.stop="toggleLevelDropdown"
						><span class="k-button-icon">
							<svg aria-hidden="true" class="k-icon">
								<use :xlink:href="'#icon-' + currentLevel"></use>
							</svg>
						</span></button>
						<dialog v-if="showLevelDropdown" class="k-dropdown-content pw-dropdown" data-theme="dark" open>
							<div class="k-navigate">
								<button
									v-for="option in levelOptions"
									:key="option"
									@click.stop="updateLevel(option)"
									type="button"
									class="k-button k-dropdown-item"
									data-has-icon="true"
								>
									<span class="k-button-icon">
										<svg class="k-icon"><use :xlink:href="'#icon-' + option"></use></svg>
									</span>
								</button>
							</div>
						</dialog>
					</span>
				</div>
			</header>
			<div class="k-input" data-type="text">
				<span class="k-input-element">
					<input
						:value="parseValue().text || ''"
						@input="handleInput"
						:placeholder="placeholder"
						type="text"
						class="k-string-input k-text-input"
					/>
				</span>
			</div>
			<footer v-if="help" class="k-field-footer">
				<div class="k-help k-field-help k-text" v-html="help"></div>
			</footer>
		</div>
	`
};
