export default {
	computed: {
		gridVars() {
      return {
        '--grid-start-sm': (Number(this.content.gridoffsetsm)),
        '--grid-span-sm': Number(this.content.gridsizesm),
        '--grid-start-md': (Number(this.content.gridoffsetmd)),
        '--grid-span-md': Number(this.content.gridsizemd),
        '--grid-start-lg': (Number(this.content.gridoffsetlg)),
        '--grid-span-lg': Number(this.content.gridsizelg),
        '--grid-start-xl': (Number(this.content.gridoffsetxl)),
        '--grid-span-xl': Number(this.content.gridsizexl),
      };
    }
  }
};