export default {
	computed: {
		gridVars() {
			const offset = (val) => { const n = Number(val); return n === 0 ? 'auto' : n + 1; };
			return {
				'--grid-start-sm': offset(this.content.gridoffsetsm),
				'--grid-span-sm':  Number(this.content.gridsizesm),
				'--grid-start-md': offset(this.content.gridoffsetmd),
				'--grid-span-md':  Number(this.content.gridsizemd),
				'--grid-start-lg': offset(this.content.gridoffsetlg),
				'--grid-span-lg':  Number(this.content.gridsizelg),
				'--grid-start-xl': offset(this.content.gridoffsetxl),
				'--grid-span-xl':  Number(this.content.gridsizexl),
			};
		}
	}
};
