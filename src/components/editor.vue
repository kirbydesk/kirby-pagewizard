<template>
  <div class="pw-editor">
    <pw-textarea v-if="mode === 'textarea'" :value="text" :align="align" />
    <pw-writer   v-else-if="mode === 'writer'"   :value="text" :align="align" />
    <pw-markdown v-else-if="mode === 'markdown'" :value="text" :align="align" />
    <div v-else class="placeholder">
      {{ $t('pw.field.text-textarea.placeholder') }}
    </div>
  </div>
</template>

<script>
import PwTextarea from './textarea.vue';
import PwWriter   from './writer.vue';
import PwMarkdown from './markdown.vue';

export default {
  components: { PwTextarea, PwWriter, PwMarkdown },
  props: {
    content: {
      type: Object,
      default: () => ({})
    }
  },
  computed: {
    parsed() {
      const val = this.content?.editor;
      if (!val) return { mode: 'textarea', text: '', align: 'left' };
      try {
        const data = typeof val === 'string' ? JSON.parse(val) : val;
        const mode = data.mode || 'textarea';
        return { mode, text: data[mode] || '', align: data.align || 'left' };
      } catch(e) {
        return { mode: 'textarea', text: '', align: 'left' };
      }
    },
    mode()  { return this.parsed.mode; },
    text()  { return this.parsed.text; },
    align() { return this.parsed.align; }
  }
}
</script>
