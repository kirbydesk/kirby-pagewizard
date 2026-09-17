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
			<span v-if="iconOf(item) && item.content.iconposition === 'left'" class="pw-link-icon" v-html="iconOf(item)"></span>
			<span v-if="item.content.linktext.length" class="k-button-text"> {{item.content.linktext}} </span>
			<span v-else class="k-button-text placeholder"> {{ $t('pw.field.link-text.placeholder') }} </span>
			<span v-if="iconOf(item) && item.content.iconposition === 'right'" class="pw-link-icon" v-html="iconOf(item)"></span>
			<svg v-if="item.content.linktype == true && item.content.linktarget == true" class="pw-external-icon" aria-hidden="true" viewBox="0 0 24 24" fill="currentColor"><path d="M10 6V8H5V19H16V14H18V20C18 20.5523 17.5523 21 17 21H4C3.44772 21 3 20.5523 3 20V7C3 6.44772 3.44772 6 4 6H10ZM21 3V11H19L18.9999 6.413L11.2071 14.2071L9.79289 12.7929L17.5849 5H13V3H21Z"/></svg>
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
	},
	methods: {
		iconOf(item) {
			const pos = item.content.iconposition;
			if (pos === 'right') return item.content.iconright || '';
			if (pos === 'left')  return item.content.iconleft  || '';
			return '';
		}
	}
}
</script>
<style scoped>
.k-button-group {
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
	.pw-external-icon {
		width: 1em;
		height: 1em;
		opacity: 0.7;
	}
	.pw-link-icon {
		display: inline-flex;
		align-items: center;
		width: 1em;
		height: 1em;
		flex-shrink: 0;
		color: var(--pw-color-button-icon, currentColor);
	}
	.pw-link-icon :deep(svg) {
		width: 100%;
		height: 100%;
		fill: currentColor;
	}
}
</style>