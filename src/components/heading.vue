<template>
	<div class="pwHeading" :data-align="align" :data-lvl="level">
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
    }
  },
  computed: {
    parsedData() {
      const val = this.content?.heading || this.value;
      if (!val) return { text: '', level: 'h2', align: 'left' };
      try {
        return typeof val === 'string' ? JSON.parse(val) : val;
      } catch(e) {
        return { text: val, level: 'h2', align: 'left' };
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
      const { align = 'left' } = this.parsedData;
      return align;
    }
  }
}
</script>
<style scoped>
div.pwHeading {
	margin-bottom: var(--spacing-2);
	line-height: var(--text-line-height);
	color: var(--pw-color-heading, inherit);

	&[data-lvl="h1"]{
		font-size: var(--text-2xl);
		font-weight: var(--font-normal);
	}
	&[data-lvl="h2"]{
		font-size: var(--text-xl);
		font-weight: var(--font-semi);
	}
	&[data-lvl="h3"]{
		font-size: var(--text-lg);
		font-weight: var(--font-bold);
	}
	&[data-lvl="h4"]{
		font-size: var(--text-md);
		font-weight: var(--font-bold);
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