export default {
	props: {
		value: String,
		label: String,
		help: String,
		placeholder: String,
		writerModes:    { type: Array,  default: () => ['textarea', 'writer', 'markdown'] },
		writerMarks:    { type: Array,  default: () => ['bold', 'italic', 'underline', 'strike', 'link'] },
		writerNodes:    { type: Array,  default: () => ['heading', 'bulletList', 'orderedList'] },
		writerHeadings: { type: Array,  default: () => [2, 3, 4] },
		writerToolbar:  { type: Object, default: () => ({ inline: false }) },
	},
	data() {
		return {
			current: this.parse(this.value),
			showModeDropdown: false,
			showAlignDropdown: false,
			_closeHandler: null,
			_updating: false,
		};
	},
	watch: {
		value(v) {
			if (this._updating) return;
			this.current = this.parse(v);
		}
	},
	computed: {
		showModeSwitcher() {
			return this.writerModes.length >= 2;
		},
		translatedLabel() {
			return this.$t('pw.field.text-' + this.current.mode, this.current.mode);
		},
		translatedHelp() {
			return this.$t('pw.field.text-' + this.current.mode + '.help', '');
		},
		translatedPlaceholder() {
			return this.$t('pw.field.text-' + this.current.mode + '.placeholder', '');
		}
	},
	methods: {
		parse(val) {
			const fallbackMode = this.writerModes[0] || 'textarea';
			const base = { mode: fallbackMode, align: 'left', textarea: '', writer: '', markdown: '' };
			if (!val) return base;
			try {
				const d = JSON.parse(val);
				if (d && typeof d === 'object' && d.mode) {
					const mode = this.writerModes.includes(d.mode) ? d.mode : fallbackMode;
					return {
						mode,
						align: d.align || 'left',
						textarea: d.textarea || '',
						writer: d.writer || '',
						markdown: d.markdown || '',
					};
				}
			} catch(e) {}
			const allowed = ['textarea', 'writer', 'markdown'];
			return { ...base, mode: allowed.includes(val) ? val : 'textarea' };
		},
		emit() {
			this._updating = true;
			this.$emit('input', JSON.stringify(this.current));
			this.$nextTick(() => { this._updating = false; });
		},
		setMode(mode) {
			this.current = { ...this.current, mode };
			this.showModeDropdown = false;
			this.emit();
		},
		setAlign(align) {
			this.current = { ...this.current, align };
			this.showAlignDropdown = false;
			this.emit();
		},
		onTextInput(e) {
			this.current = { ...this.current, [this.current.mode]: e.target.value };
			this.autoResize(e.target);
			this.emit();
		},
		onWriterInput(html) {
			this.current = { ...this.current, writer: html };
			this.emit();
		},
		autoResize(el) {
			el.style.height = 'auto';
			el.style.height = el.scrollHeight + 'px';
			el.style.minHeight = el.scrollHeight + 'px';
		},
		toggleModeDropdown() {
			this.showModeDropdown = !this.showModeDropdown;
			if (this.showModeDropdown) this.showAlignDropdown = false;
		},
		toggleAlignDropdown() {
			this.showAlignDropdown = !this.showAlignDropdown;
			if (this.showAlignDropdown) this.showModeDropdown = false;
		},
		handleClose(e) {
			if (!this.$el.contains(e.target)) {
				this.showModeDropdown = false;
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
		<div class="k-field pw-editor-field">
			<header class="k-field-header" style="display:flex;align-items:center;overflow:visible;">
				<label class="k-label k-field-label" style="flex:1;">
					<span class="k-label-text">{{ $t('pw.field.text') }}</span>
				</label>
				<span style="display:flex;align-items:center;">
					<span style="position:relative;">
						<button
							data-has-icon="true"
							data-has-text="false"
							aria-label="Align"
							data-responsive="true"
							data-size="xs"
							data-variant="filled"
							type="button"
							class="input-focus k-button"
							@click.stop="toggleAlignDropdown"
							><span class="k-button-icon">
								<svg aria-hidden="true" data-type="editor-mode" class="k-icon">
									<use :xlink:href="'#icon-text-' + current.align"></use>
								</svg>
							</span>
						</button>
						<dialog v-if="showAlignDropdown" class="k-dropdown-content pw-dropdown" data-theme="dark" open>
							<div class="k-navigate">
								<button v-for="opt in ['left','center','right']" :key="opt" type="button" class="k-button k-dropdown-item" data-has-icon="true" @click.stop="setAlign(opt)">
									<span class="k-button-icon"><svg class="k-icon"><use :xlink:href="'#icon-text-' + opt"></use></svg></span>
								</button>
							</div>
						</dialog>
					</span>
					<span v-if="showModeSwitcher" style="position:relative;">
						<button
							data-has-icon="false"
							data-has-text="true"
							aria-label="Mode"
							data-responsive="true"
							data-size="xs"
							data-variant="filled"
							type="button"
							class="input-focus k-button"
							@click.stop="toggleModeDropdown"
							><span class="k-button-text"> {{ translatedLabel }} </span>
						</button>
						<div v-if="showModeDropdown" style="position:absolute;top:100%;right:0;left:auto;z-index:9999;background:var(--color-black);border-radius:var(--rounded);padding:4px;white-space:nowrap;box-shadow:var(--shadow);" @click.stop>
							<button v-for="m in writerModes" :key="m" type="button" style="display:block;width:100%;text-align:left;padding:.52rem .6rem;color:#fff;background:none;border:none;cursor:pointer;white-space:nowrap;" @click.stop="setMode(m)">
								{{ $t('pw.field.text-' + m) }}
							</button>
						</div>
					</span>
				</span>
			</header>
			<div v-show="current.mode === 'textarea'" class="k-input pw-editor-textarea" data-type="textarea">
				<span class="k-input-element">
					<textarea
						:value="current.textarea"
						:placeholder="translatedPlaceholder"
						class="k-string-input k-textarea-input pw-textarea"
						@input="onTextInput"
					></textarea>
				</span>
			</div>
			<div v-show="current.mode === 'markdown'" class="k-input pw-editor-textarea" data-type="textarea">
				<span class="k-input-element">
					<textarea
						:value="current.markdown"
						:placeholder="translatedPlaceholder"
						class="k-string-input k-textarea-input pw-textarea"
						@input="onTextInput"
					></textarea>
				</span>
			</div>
			<k-input
				v-if="current.mode === 'writer'"
				type="writer"
				:value="current.writer"
				:marks="writerMarks"
				:nodes="writerNodes"
				:headings="writerHeadings"
				:toolbar="writerToolbar"
				@input="onWriterInput"
			></k-input>
			<footer v-if="translatedHelp" class="k-field-footer">
				<div class="k-help k-field-help k-text" v-html="translatedHelp"></div>
			</footer>
		</div>
	`
};
