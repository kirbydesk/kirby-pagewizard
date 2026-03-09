export default {
	extends: 'k-text-field',
	mounted() {
		this.$nextTick(() => {
			const endpoint = this.endpoints?.field || '';
			const isSharedContext = endpoint.includes('/sharedblocks/');

			if (!isSharedContext) {
				if (this.$el) this.$el.style.display = 'none';
				return;
			}

			const d = new Date();
			const pad = n => String(n).padStart(2, '0');
			const title = this.$panel?.drawer?.props?.title || '';
			const prefix = title ? title + ' ' : '';
			const generated = `${prefix}${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())} ${pad(d.getHours())}:${pad(d.getMinutes())}`;

			if (!this.value) {
				this.$emit('input', generated);
				setTimeout(() => {
					const input = this.$el?.querySelector('input');
					if (!input) return;
					input.style.color = 'var(--color-gray-500, #999)';
					input.addEventListener('input', () => {
						input.style.color = '';
					}, { once: true });
				}, 0);
			}
		});
	}
};
