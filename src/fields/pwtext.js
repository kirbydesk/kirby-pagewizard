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
		const parsed = this.parseValue();
		return {
			current: {
				align: parsed.align || this.align || 'left',
				level: parsed.level || this.level || 'h2',
				size: parsed.size || this.size || '2xl',
				textbackground: parsed.textbackground || this.textbackground || null,
				multiline: parsed.multiline || this.multiline || null,
				flourish: parsed.flourish || this.flourish || null,
			}
		}
	},
	computed: {
		// the dropdowns shown (each only with its preset and options), in the
		// order of the drawer
		toolbarItems() {
			return ['flourish', 'multiline', 'textbackground', 'align', 'size', 'level']
				.filter(key => this[key] && this[key + 'Options'])
				.map(key => ({ key, value: this.current[key], options: this[key + 'Options'] }));
		}
	},
	watch: {
		value() {
			const parsed = this.parseValue();
			for (const key of Object.keys(this.current)) {
				if (parsed[key]) this.current[key] = parsed[key];
			}
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
		emitValue(text) {
			const { align, level, size, textbackground, multiline, flourish } = this.current;
			const data = { text, align, level, size };
			if (textbackground) data.textbackground = textbackground;
			if (multiline) data.multiline = multiline;
			if (flourish) data.flourish = flourish;
			this.$emit('input', JSON.stringify(data));
		},
		// a dropdown chose a value
		setOption({ key, value }) {
			this.current[key] = value;
			this.emitValue(this.parseValue().text || '');
		},
		handleInput(event) {
			this.emitValue(event.target.value);
		}
	},
	template: `
		<div class="k-field k-text-field" :data-align="current.align" :data-level="current.level" :data-size="current.size">
			<header class="k-field-header" style="display:flex;align-items:center;overflow:visible;">
				<label v-if="label" class="k-label k-field-label" style="flex:1;">
					<span class="k-label-text">{{ label }}</span>
				</label>
				<span v-else style="flex:1;"></span>
				<pw-field-toolbar v-if="toolbarItems.length" :items="toolbarItems" @input="setOption" />
			</header>
			<div class="k-input" data-type="text">
				<span class="k-input-element">
					<textarea
						v-if="current.multiline === 'enabled'"
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
