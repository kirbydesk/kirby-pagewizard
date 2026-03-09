<template>
	<div class="pwButton" :data-align="align">
		<button data-has-text="true" data-responsive="true" data-size="sm" data-variant="filled" type="button" class="k-button">
			<span v-if="content.linktext?.length" class="k-button-text" v-html="content.linktext"></span>
			<span v-else class="k-button-text placeholder"> {{ $t('pw.field.link-text.placeholder') }} </span>
		</button>
	</div>
</template>
<script>
export default {
	props: {
		content:      { type: Object, default: () => ({}) },
		alignDefault: { type: String, default: 'left' }
	},
	computed: {
		align() {
			return this.content.buttonalignment || this.alignDefault;
		}
	}
}
</script>
<style scoped>
.pwButton {
	display: flex;
	&[data-align="left"]   { justify-content: flex-start; }
	&[data-align="center"] { justify-content: center; }
	&[data-align="right"]  { justify-content: flex-end; }
}
button {
	margin: var(--spacing-3);
	padding: var(--spacing-4) var(--spacing-2);
	background-color: var(--color-gray-600);
	color: white;

	.k-button-text.placeholder {
		opacity: 0.5;
	}
}
</style>