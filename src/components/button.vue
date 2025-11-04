<template>
		<div @dblclick="open">
			<button :data-style="content.style" v-if="content.link.length" data-has-text="true" data-responsive="true" data-size="sm" data-variant="filled" type="button" class="k-button" :style="{'color':content.textcolor,'background':content.bgcolor}">
				<span v-if="content.linktext.length" class="k-button-text" v-html="content.linktext" @blur="update({ linktext: $event.target.innerText });"></span>
				<em v-else class="k-button-text placeholder"> {{ $t('pw.field.linktext.placeholder') }} </em>
			</button>

			<button v-else class="k-button" data-has-text="true" data-responsive="true" data-size="sm" data-variant="filled" type="button" style="opacity:.5;">
				<span v-if="content.linktext.length" class="k-button-text placeholder" v-html="content.linktext"></span>
				<em v-else class="k-button-text placeholder"> {{ $t('pw.field.linktext.placeholder') }} </em>
			</button>
		</div>
</template>
<script>
import Icon from '@/components/icon.vue';

export default {
	components: {
		Icon
	}
}
</script>
<style scoped>
button {
	padding: var(--spacing-4) var(--spacing-2);
	border: 1px solid transparent;
	background-color: var(--color-blue-600);
	border-color: var(--color-blue-600);
	color: white;
	width: 100%;

	.k-button {
		gap: 0 !important;
	}
}
</style>