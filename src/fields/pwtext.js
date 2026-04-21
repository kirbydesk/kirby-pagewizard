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
		textbackground: String,
		alignOptions: {
			default: null
		},
		levelOptions: {
			default: null
		},
		sizeOptions: {
			type: Array,
			default: null
		},
		textbackgroundOptions: {
			type: Array,
			default: null
		}
	},
	data() {
		return {
			currentAlign: this.parseValue().align || (this.align || 'left'),
			currentLevel: this.parseValue().level || (this.level || 'h2'),
			currentSize: this.parseValue().size || this.size || '2xl',
			currentTextbackground: this.parseValue().textbackground || this.textbackground || null,
			showAlignDropdown: false,
			showLevelDropdown: false,
			showSizeDropdown: false,
			showTextbackgroundDropdown: false
		}
	},
	watch: {
		value(newValue) {
			const parsed = this.parseValue();
			if (parsed.align) this.currentAlign = parsed.align;
			if (parsed.level) this.currentLevel = parsed.level;
			if (parsed.size) this.currentSize = parsed.size;
			if (parsed.textbackground) this.currentTextbackground = parsed.textbackground;
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
		emitValue(text, align, level, size, textbackground) {
			const data = { text, align, level, size };
			if (textbackground) data.textbackground = textbackground;
			this.$emit('input', JSON.stringify(data));
		},
		updateAlign(value) {
			this.currentAlign = value;
			this.showAlignDropdown = false;
			const parsed = this.parseValue();
			this.emitValue(parsed.text || '', value, parsed.level || this.currentLevel, parsed.size || this.currentSize, this.currentTextbackground);
		},
		updateLevel(value) {
			this.currentLevel = value;
			this.showLevelDropdown = false;
			const parsed = this.parseValue();
			this.emitValue(parsed.text || '', parsed.align || this.currentAlign, value, parsed.size || this.currentSize, this.currentTextbackground);
		},
		updateSize(value) {
			this.currentSize = value;
			this.showSizeDropdown = false;
			const parsed = this.parseValue();
			this.emitValue(parsed.text || '', parsed.align || this.currentAlign, parsed.level || this.currentLevel, value, this.currentTextbackground);
		},
		updateTextbackground(value) {
			this.currentTextbackground = value;
			this.showTextbackgroundDropdown = false;
			const parsed = this.parseValue();
			this.emitValue(parsed.text || '', parsed.align || this.currentAlign, parsed.level || this.currentLevel, parsed.size || this.currentSize, value);
		},
		handleInput(event) {
			this.emitValue(event.target.value, this.currentAlign, this.currentLevel, this.currentSize, this.currentTextbackground);
		},
		closeDropdowns() {
			this.showAlignDropdown = false;
			this.showLevelDropdown = false;
			this.showSizeDropdown = false;
			this.showTextbackgroundDropdown = false;
		},
		toggleLevelDropdown() {
			const was = this.showLevelDropdown;
			this.closeDropdowns();
			this.showLevelDropdown = !was;
		},
		toggleAlignDropdown() {
			const was = this.showAlignDropdown;
			this.closeDropdowns();
			this.showAlignDropdown = !was;
		},
		toggleSizeDropdown() {
			const was = this.showSizeDropdown;
			this.closeDropdowns();
			this.showSizeDropdown = !was;
		},
		toggleTextbackgroundDropdown() {
			const was = this.showTextbackgroundDropdown;
			this.closeDropdowns();
			this.showTextbackgroundDropdown = !was;
		},
		handleClickOutside(event) {
			if (!this.$el.contains(event.target)) {
				this.closeDropdowns();
			}
		},
		textbackgroundIcon(val) {
			const icons = {
				disabled: '<path d="M9 4.9967V11.2694H7V4.9967H5V13.9967H19V4.9967H9ZM20 15.9967H4V17.9967H20V15.9967ZM3 13.9967V3.9967C3 3.44442 3.44772 2.9967 4 2.9967H20C20.5523 2.9967 21 3.44442 21 3.9967V13.9967H22V18.9967C22 19.549 21.5523 19.9967 21 19.9967H13V22.9967H11V19.9967H3C2.44772 19.9967 2 19.549 2 18.9967V13.9967H3Z"/>',
				enabled: '<path d="M20 15.9967H4V17.9967H20V15.9967ZM3 13.9967V3.9967C3 3.44442 3.44772 2.9967 4 2.9967H7V11.2694H9V2.9967H20C20.5523 2.9967 21 3.44442 21 3.9967V13.9967H22V18.9967C22 19.549 21.5523 19.9967 21 19.9967H13V22.9967H11V19.9967H3C2.44772 19.9967 2 19.549 2 18.9967V13.9967H3Z"/>'
			};
			return icons[val] || icons['disabled'];
		},
		handleEscape(event) {
			if (event.key === 'Escape' && (this.showAlignDropdown || this.showLevelDropdown || this.showSizeDropdown || this.showTextbackgroundDropdown)) {
				event.stopPropagation();
				event.preventDefault();
				this.closeDropdowns();
			}
		},
		sizeLabel(size) {
			return this.$t('pw.option.' + size, size);
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
				<div v-if="(align && alignOptions) || (level && levelOptions) || (size && sizeOptions) || (textbackground && textbackgroundOptions)" class="k-button-group">
					<span v-if="textbackground && textbackgroundOptions" style="position:relative;">
						<button
							data-has-icon="true"
							data-has-text="false"
							aria-label="Text background"
							data-size="xs"
							data-variant="filled"
							type="button"
							class="input-focus k-button"
							@click.stop="toggleTextbackgroundDropdown"
						><span class="k-button-icon"><svg aria-hidden="true" class="k-icon" viewBox="0 0 24 24" fill="currentColor" v-html="textbackgroundIcon(currentTextbackground)"></svg></span></button>
						<dialog v-if="showTextbackgroundDropdown" class="k-dropdown-content pw-dropdown" data-theme="dark" open>
							<div class="k-navigate">
								<button
									v-for="option in textbackgroundOptions"
									:key="option"
									@click.stop="updateTextbackground(option)"
									type="button"
									class="k-button k-dropdown-item"
									data-has-icon="true"
								>
									<span class="k-button-icon"><svg class="k-icon" viewBox="0 0 24 24" fill="currentColor" v-html="textbackgroundIcon(option)"></svg></span>
								</button>
							</div>
						</dialog>
					</span>
					<span v-if="align && alignOptions" style="position:relative;">
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
					<span v-if="size && sizeOptions" style="position:relative;">
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
					<span v-if="level && levelOptions" style="position:relative;">
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
