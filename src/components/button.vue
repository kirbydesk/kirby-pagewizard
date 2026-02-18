<template>
	<div @dblclick="open">
		<button data-has-text="true" data-responsive="true" data-size="sm" data-variant="filled" type="button" class="k-button">
			<span v-if="content.linktext.length" class="k-button-text" v-html="content.linktext" @blur="update({ linktext: $event.target.innerText });"></span>
			<span v-else class="k-button-text placeholder"> {{ $t('pw.field.link-text.placeholder') }} </span>
		</button>
	</div>
</template>
<script>
</script>
<style scoped>
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