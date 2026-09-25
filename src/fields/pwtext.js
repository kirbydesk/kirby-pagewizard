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
		multiline: String,
		flourish: String,
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
		},
		multilineOptions: {
			type: Array,
			default: null
		},
		flourishOptions: {
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
			currentMultiline: this.parseValue().multiline || this.multiline || null,
			currentFlourish: this.parseValue().flourish || this.flourish || null,
			showAlignDropdown: false,
			showLevelDropdown: false,
			showSizeDropdown: false,
			showTextbackgroundDropdown: false,
			showMultilineDropdown: false,
			showFlourishDropdown: false
		}
	},
	watch: {
		value(newValue) {
			const parsed = this.parseValue();
			if (parsed.align) this.currentAlign = parsed.align;
			if (parsed.level) this.currentLevel = parsed.level;
			if (parsed.size) this.currentSize = parsed.size;
			if (parsed.textbackground) this.currentTextbackground = parsed.textbackground;
			if (parsed.multiline) this.currentMultiline = parsed.multiline;
			if (parsed.flourish) this.currentFlourish = parsed.flourish;
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
		emitValue(text, align, level, size, textbackground, multiline, flourish) {
			const data = { text, align, level, size };
			if (textbackground) data.textbackground = textbackground;
			if (multiline) data.multiline = multiline;
			if (flourish) data.flourish = flourish;
			this.$emit('input', JSON.stringify(data));
		},
		updateAlign(value) {
			this.currentAlign = value;
			this.showAlignDropdown = false;
			const parsed = this.parseValue();
			this.emitValue(parsed.text || '', value, parsed.level || this.currentLevel, parsed.size || this.currentSize, this.currentTextbackground, this.currentMultiline, this.currentFlourish);
		},
		updateLevel(value) {
			this.currentLevel = value;
			this.showLevelDropdown = false;
			const parsed = this.parseValue();
			this.emitValue(parsed.text || '', parsed.align || this.currentAlign, value, parsed.size || this.currentSize, this.currentTextbackground, this.currentMultiline, this.currentFlourish);
		},
		updateSize(value) {
			this.currentSize = value;
			this.showSizeDropdown = false;
			const parsed = this.parseValue();
			this.emitValue(parsed.text || '', parsed.align || this.currentAlign, parsed.level || this.currentLevel, value, this.currentTextbackground, this.currentMultiline, this.currentFlourish);
		},
		updateTextbackground(value) {
			this.currentTextbackground = value;
			this.showTextbackgroundDropdown = false;
			const parsed = this.parseValue();
			this.emitValue(parsed.text || '', parsed.align || this.currentAlign, parsed.level || this.currentLevel, parsed.size || this.currentSize, value, this.currentMultiline, this.currentFlourish);
		},
		updateMultiline(value) {
			this.currentMultiline = value;
			this.showMultilineDropdown = false;
			const parsed = this.parseValue();
			this.emitValue(parsed.text || '', parsed.align || this.currentAlign, parsed.level || this.currentLevel, parsed.size || this.currentSize, this.currentTextbackground, value, this.currentFlourish);
		},
		updateFlourish(value) {
			this.currentFlourish = value;
			this.showFlourishDropdown = false;
			const parsed = this.parseValue();
			this.emitValue(parsed.text || '', parsed.align || this.currentAlign, parsed.level || this.currentLevel, parsed.size || this.currentSize, this.currentTextbackground, this.currentMultiline, value);
		},
		handleInput(event) {
			this.emitValue(event.target.value, this.currentAlign, this.currentLevel, this.currentSize, this.currentTextbackground, this.currentMultiline, this.currentFlourish);
		},
		closeDropdowns() {
			this.showAlignDropdown = false;
			this.showLevelDropdown = false;
			this.showSizeDropdown = false;
			this.showTextbackgroundDropdown = false;
			this.showMultilineDropdown = false;
			this.showFlourishDropdown = false;
		},
		// "div" (no heading element, e.g. a slogan) has no Kirby h-icon → own icon
		levelIcon(level) {
			return level === 'div' ? 'pw-level-div' : level;
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
		toggleMultilineDropdown() {
			const was = this.showMultilineDropdown;
			this.closeDropdowns();
			this.showMultilineDropdown = !was;
		},
		toggleFlourishDropdown() {
			const was = this.showFlourishDropdown;
			this.closeDropdowns();
			this.showFlourishDropdown = !was;
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
		multilineIcon(val) {
			const icons = {
				disabled: '<path d="M5 19H19V5H5V19ZM3 4C3 3.44772 3.44772 3 4 3H20C20.5523 3 21 3.44772 21 4V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V4ZM10 8V11H14V8L18 12L14 16V13H10V16L6 12L10 8Z"/>',
				enabled: '<path d="M5 19H19V5H5V19ZM3 4C3 3.44772 3.44772 3 4 3H20C20.5523 3 21 3.44772 21 4V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V4ZM8 10L12 6L16 10H13V14H16L12 18L8 14H11V10L8 10Z"/>'
			};
			return icons[val] || icons['disabled'];
		},
		flourishIcon(val) {
			const icons = {
				disabled: '<path d="M5.55397 22H3.3999L10.9999 3H12.9999L20.5999 22H18.4458L16.0458 16H7.95397L5.55397 22ZM8.75397 14H15.2458L11.9999 5.88517L8.75397 14Z"/>',
				enabled: '<path d="M15.2459 14H8.75407L7.15407 18H5L11 3H13L19 18H16.8459L15.2459 14ZM14.4459 12L12 5.88516L9.55407 12H14.4459ZM3 20H21V22H3V20Z"/>'
			};
			return icons[val] || icons['disabled'];
		},
		handleEscape(event) {
			if (event.key === 'Escape' && (this.showAlignDropdown || this.showLevelDropdown || this.showSizeDropdown || this.showTextbackgroundDropdown || this.showMultilineDropdown || this.showFlourishDropdown)) {
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
				<div v-if="(align && alignOptions) || (level && levelOptions) || (size && sizeOptions) || (textbackground && textbackgroundOptions) || (multiline && multilineOptions) || (flourish && flourishOptions)" class="k-button-group">
					<span v-if="flourish && flourishOptions" style="position:relative;">
						<button
							data-has-icon="true"
							data-has-text="false"
							:aria-label="$t('pw.toolbar.flourish')"
							data-size="xs"
							data-variant="filled"
							type="button"
							class="input-focus k-button"
							@click.stop="toggleFlourishDropdown"
						><span class="k-button-icon"><svg aria-hidden="true" class="k-icon" viewBox="0 0 24 24" fill="currentColor" v-html="flourishIcon(currentFlourish)"></svg></span></button>
						<dialog v-if="showFlourishDropdown" class="k-dropdown-content pw-dropdown" data-theme="dark" open>
							<div class="k-navigate">
								<button
									v-for="option in flourishOptions"
									:key="option"
									@click.stop="updateFlourish(option)"
									type="button"
									class="k-button k-dropdown-item"
									data-has-icon="true"
								>
									<span class="k-button-icon"><svg class="k-icon" viewBox="0 0 24 24" fill="currentColor" v-html="flourishIcon(option)"></svg></span>
								</button>
							</div>
						</dialog>
					</span>
					<span v-if="multiline && multilineOptions" style="position:relative;">
						<button
							data-has-icon="true"
							data-has-text="false"
							:aria-label="$t('pw.toolbar.multiline')"
							data-size="xs"
							data-variant="filled"
							type="button"
							class="input-focus k-button"
							@click.stop="toggleMultilineDropdown"
						><span class="k-button-icon"><svg aria-hidden="true" class="k-icon" viewBox="0 0 24 24" fill="currentColor" v-html="multilineIcon(currentMultiline)"></svg></span></button>
						<dialog v-if="showMultilineDropdown" class="k-dropdown-content pw-dropdown" data-theme="dark" open>
							<div class="k-navigate">
								<button
									v-for="option in multilineOptions"
									:key="option"
									@click.stop="updateMultiline(option)"
									type="button"
									class="k-button k-dropdown-item"
									data-has-icon="true"
								>
									<span class="k-button-icon"><svg class="k-icon" viewBox="0 0 24 24" fill="currentColor" v-html="multilineIcon(option)"></svg></span>
								</button>
							</div>
						</dialog>
					</span>
					<span v-if="textbackground && textbackgroundOptions" style="position:relative;">
						<button
							data-has-icon="true"
							data-has-text="false"
							:aria-label="$t('pw.toolbar.textbackground')"
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
							:aria-label="$t('pw.toolbar.align')"
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
							:aria-label="$t('pw.toolbar.size')"
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
							:aria-label="$t('pw.toolbar.level')"
							data-size="xs"
							data-variant="filled"
							type="button"
							class="input-focus k-button"
							@click.stop="toggleLevelDropdown"
						><span class="k-button-icon">
							<svg aria-hidden="true" class="k-icon">
								<use :xlink:href="'#icon-' + levelIcon(currentLevel)"></use>
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
										<svg class="k-icon"><use :xlink:href="'#icon-' + levelIcon(option)"></use></svg>
									</span>
								</button>
							</div>
						</dialog>
					</span>
				</div>
			</header>
			<div class="k-input" data-type="text">
				<span class="k-input-element">
					<textarea
						v-if="currentMultiline === 'enabled'"
						:value="parseValue().text || ''"
						@input="handleInput"
						:placeholder="placeholder"
						class="k-textarea-input"
						rows="3"
						style="width:100%;font:inherit;resize:vertical;padding:0.5rem;"
					></textarea>
					<input
						v-else
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
