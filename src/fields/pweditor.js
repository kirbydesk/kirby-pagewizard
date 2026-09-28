export default {
	props: {
		value: String,
		label:       String,
		placeholder: String,
		fieldHelp:   String,
		align:          { type: String, default: 'left' },
		alignOptions:   { type: Array,  default: () => ['left', 'center', 'right'] },
		size:           { type: String, default: null },
		sizeOptions:    { type: Array,  default: null },
		defaultMode:    { type: String, default: null },
		writerModes:    { type: Array,  default: () => ['textarea', 'writer', 'markdown'] },
		writerMarks:    { type: Array,  default: () => ['bold', 'italic', 'underline', 'strike', 'link'] },
		writerNodes:    { type: Array,  default: () => ['heading', 'bulletList', 'orderedList'] },
		writerHeadings: { type: Array,  default: () => [2, 3, 4] },
		writerToolbar:  { type: Object, default: () => ({ inline: false }) },
	},
	data() {
		return {
			current: this.parse(this.value),
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
			return this.label || this.$t('pw.field.text');
		},
		// the dropdowns shown, in the order of the drawer: alignment, size
		// (with a preset), editor mode (with at least two)
		toolbarItems() {
			const items = [{ key: 'align', value: this.current.align, options: this.alignOptions }];
			if (this.size && this.sizeOptions) items.push({ key: 'size', value: this.current.size, options: this.sizeOptions });
			if (this.showModeSwitcher) items.push({ key: 'mode', value: this.current.mode, options: this.writerModes });
			return items;
		},
		translatedHelp() {
			return this.fieldHelp || this.$t('pw.field.text-' + this.current.mode + '.help', '');
		},
		translatedPlaceholder() {
			return this.placeholder || this.$t('pw.field.text-' + this.current.mode + '.placeholder', '');
		}
	},
	methods: {
		parse(val) {
			const fallbackMode = (this.defaultMode && this.writerModes.includes(this.defaultMode))
				? this.defaultMode
				: (this.writerModes[0] || 'textarea');
			const base = { mode: fallbackMode, align: this.align, size: this.size, textarea: '', writer: '', markdown: '' };
			if (!val) return base;
			try {
				const d = JSON.parse(val);
				if (d && typeof d === 'object' && d.mode) {
					const mode = this.writerModes.includes(d.mode) ? d.mode : fallbackMode;
					return {
						mode,
						align: d.align || this.align,
						size: d.size || this.size,
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
		// a dropdown chose a value (align, size or mode)
		setOption({ key, value }) {
			this.current = { ...this.current, [key]: value };
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
		}
	},
	mounted() {
		this.$nextTick(() => {
			const ta = this.$el.querySelector('textarea');
			if (ta) this.autoResize(ta);
		});
	},
	template: `
		<div class="k-field pw-editor-field">
			<header class="k-field-header" style="display:flex;align-items:center;overflow:visible;">
				<label class="k-label k-field-label" style="flex:1;">
					<span class="k-label-text">{{ translatedLabel }}</span>
				</label>
				<pw-field-toolbar :items="toolbarItems" @input="setOption" />
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
				:placeholder="translatedPlaceholder"
				@input="onWriterInput"
			></k-input>
			<footer v-if="translatedHelp" class="k-field-footer">
				<div class="k-help k-field-help k-text" v-html="translatedHelp"></div>
			</footer>
		</div>
	`
};
