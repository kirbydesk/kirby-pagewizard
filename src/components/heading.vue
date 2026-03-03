<template>
	<div class="pwHeading" :data-align="align" :data-lvl="level" :data-size="size">
    <div v-if="text" v-html="text"></div>
    <div v-else class="placeholder">
      {{ $t('pw.field.heading.placeholder') }}
    </div>
  </div>
</template>
<script>
export default {
  props: {
    value: String,
    content: {
      type: Object,
      default: () => ({})
    },
    alignDefault: { type: String, default: 'left' }
  },
  computed: {
    parsedData() {
      const val = this.content?.heading || this.value;
      if (!val) return { text: '', level: 'h2', align: this.alignDefault };
      try {
        return typeof val === 'string' ? JSON.parse(val) : val;
      } catch(e) {
        return { text: val, level: 'h2', align: this.alignDefault };
      }
    },
    text() {
      const { text = '' } = this.parsedData;
      return text;
    },
    level() {
      const { level = 'h2' } = this.parsedData;
      return level;
    },
    align() {
      const { align = this.alignDefault } = this.parsedData;
      return align;
    },
    size() {
      const { size = 'normal' } = this.parsedData;
      return size;
    }
  }
}
</script>
<style scoped>
div.pwHeading {
	color: var(--pw-color-heading, inherit);
	line-height: 1.3;

	&[data-lvl="h1"]{
		font-size: var(--text-xl);
		font-weight: var(--font-normal);

		&[data-size="large"]{ font-size: var(--text-2xl); }
		&[data-size="xlarge"]{ font-size: var(--text-3xl); }
	}
	&[data-lvl="h2"]{
		font-size: var(--text-lg);
		font-weight: var(--font-semi);

		&[data-size="large"]{ font-size: var(--text-xl); }
		&[data-size="xlarge"]{ font-size: var(--text-2xl); }
	}
	&[data-lvl="h3"]{
		font-size: var(--text-md);
		font-weight: var(--font-bold);

		&[data-size="large"]{ font-size: var(--text-lg); }
		&[data-size="xlarge"]{ font-size: var(--text-xl); }
	}
	&[data-lvl="h4"]{
		font-size: var(--text-sm);
		font-weight: var(--font-bold);

		&[data-size="large"]{ font-size: var(--text-md); }
		&[data-size="xlarge"]{ font-size: var(--text-lg); }
	}
	&[data-align="left"] {
    text-align: left;
  }
  &[data-align="center"] {
    text-align: center;
  }
  &[data-align="right"] {
    text-align: right;
  }
}
</style>