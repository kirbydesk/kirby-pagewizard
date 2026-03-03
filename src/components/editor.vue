<template>
  <div class="pwEditor">
    <pw-textarea v-if="mode === 'textarea'" :value="text" :align="align" :size="size"/>
    <pw-writer   v-else-if="mode === 'writer'"   :value="text" :align="align" :size="size"/>
    <pw-markdown v-else-if="mode === 'markdown'" :value="text" :align="align" :size="size"/>
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
    },
    alignDefault: { type: String, default: 'left' }
  },
  computed: {
    parsed() {
      const val = this.content?.editor;
      if (!val) return { mode: 'textarea', text: '', align: this.alignDefault };
      try {
        const data = typeof val === 'string' ? JSON.parse(val) : val;
        const mode = data.mode || 'textarea';
        return { mode, text: data[mode] || '', align: data.align || this.alignDefault, size: data.size || null };
      } catch(e) {
        return { mode: 'textarea', text: '', align: this.alignDefault };
      }
    },
    mode()  { return this.parsed.mode; },
    text()  { return this.parsed.text; },
    align() {
      return this.parsed.align || this.alignDefault;
    },
    size() {
      return this.parsed.size || null;
    }
  }
}
</script>