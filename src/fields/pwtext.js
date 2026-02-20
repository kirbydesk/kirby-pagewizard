export default {
	extends: 'k-text-field',
	props: {
		label: String,
		help: String,
		placeholder: String,
		value: String,
		align: String,
		level: String,
		alignOptions: {
			type: Array,
			default: () => ['left', 'center', 'right']
		},
		levelOptions: {
			type: Array,
			default: () => ['h1', 'h2', 'h3', 'h4']
		}
	},
	data() {
		return {
			currentAlign: this.parseValue().align || (this.align || 'left'),
			currentLevel: this.parseValue().level || (this.level || 'h2'),
			showAlignDropdown: false,
			showLevelDropdown: false
		}
	},
	watch: {
		value(newValue) {
			const parsed = this.parseValue();
			if (parsed.align) this.currentAlign = parsed.align;
			if (parsed.level) this.currentLevel = parsed.level;
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
		emitValue(text, align, level) {
			const data = {
				text: text,
				align: align,
				level: level
			};
			this.$emit('input', JSON.stringify(data));
		},
		updateAlign(value) {
			this.currentAlign = value;
			this.showAlignDropdown = false;
			const parsed = this.parseValue();
			this.emitValue(parsed.text || '', value, parsed.level || this.currentLevel);
		},
		updateLevel(value) {
			this.currentLevel = value;
			this.showLevelDropdown = false;
			const parsed = this.parseValue();
			this.emitValue(parsed.text || '', parsed.align || this.currentAlign, value);
		},
		handleInput(event) {
			this.emitValue(event.target.value, this.currentAlign, this.currentLevel);
		},
		closeDropdowns() {
			this.showAlignDropdown = false;
			this.showLevelDropdown = false;
		},
		toggleLevelDropdown() {
			this.showAlignDropdown = false;
			this.showLevelDropdown = !this.showLevelDropdown;
		},
		toggleAlignDropdown() {
			this.showLevelDropdown = false;
			this.showAlignDropdown = !this.showAlignDropdown;
		},
		handleClickOutside(event) {
			if (!this.$el.contains(event.target)) {
				this.closeDropdowns();
			}
		},
		handleEscape(event) {
			if (event.key === 'Escape') {
				if (this.showAlignDropdown || this.showLevelDropdown) {
					event.stopPropagation();
					event.preventDefault();
					this.closeDropdowns();
				}
			}
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
		<div class="k-field k-text-field" :data-align="currentAlign" :data-level="currentLevel">
			<header v-if="label" class="k-field-header">
				<label class="k-label k-field-label">
					<span class="k-label-text">{{ label }}</span>
				</label>
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
				<span v-if="level" class="k-input-icon" @click.stop="toggleLevelDropdown">
					<svg aria-hidden="true" :data-type="currentLevel" class="k-icon">
						<use :xlink:href="'#icon-' + currentLevel"></use>
					</svg>
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
				<span v-if="align" class="k-input-icon" @click.stop="toggleAlignDropdown">
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
			</div>
			<footer v-if="help" class="k-field-footer">
				<div class="k-help k-field-help k-text" v-html="help"></div>
			</footer>
		</div>
	`
};
