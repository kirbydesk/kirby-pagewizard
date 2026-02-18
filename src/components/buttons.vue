<template>
	<div class="k-button-group" v-if="value && value.length" :data-align="align">
		<div v-for="item in value" :key="item.id" :class="{'ishidden': item.isHidden}">
			<button
				type="button"
				class="k-button"
				data-has-text="true"
				data-responsive="true"
				data-size="md"
				data-variant="filled"
			>
			<span v-if="item.content.linktext.length" class="k-button-text"> {{item.content.linktext}} </span>
			<span v-else class="k-button-text placeholder"> {{ $t('pw.field.link-text.placeholder') }} </span>
			</button>
		</div>
	</div>
</template>
<script>
export default {
	props: {
		value: String,
		align: {
			type: String,
			default: 'left'
		}
	}
}
</script>
<style scoped>
.k-button-group {
	margin: var(--spacing-4) 0 var(--spacing-2);
	display: flex;
	flex-wrap: wrap;
	gap: var(--spacing-2);

	&[data-align="left"] { justify-content: flex-start; }
	&[data-align="center"] { justify-content: center; }
	&[data-align="right"] { justify-content: flex-end; }
}
button {
	padding: var(--spacing-4) var(--spacing-2);
	background-color: var(--pw-color-button-background, var(--color-gray-600));
	color: var(--pw-color-button-text, white);

	.k-button-text.placeholder {
		opacity: 0.5;
	}
}
</style>