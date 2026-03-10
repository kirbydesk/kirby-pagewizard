export default {
	extends: 'k-text-field',
	mounted() {
		this.$nextTick(() => {
			const endpoint = this.endpoints?.field || '';
			const isSharedContext = endpoint.includes('/sharedblocks/');

			if (!isSharedContext) {
				if (this.$el) {
					this.$el.style.display = 'none';
					const col = this.$el.closest('.k-column');
					if (col) col.style.display = 'none';
				}
				return;
			}

			const myCol = this.$el?.closest('.k-column');
		const fragmentCol = myCol?.nextElementSibling;
		if (fragmentCol) fragmentCol.style.display = 'none';

		const d = new Date();
			const pad = n => String(n).padStart(2, '0');
			const generated = `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())} ${pad(d.getHours())}:${pad(d.getMinutes())}:${pad(d.getSeconds())}`;

			if (!this.value) {
				this.$emit('input', generated);
				setTimeout(() => {
					const input = this.$el?.querySelector('input');
					if (!input) return;
					input.style.color = 'var(--color-gray-500, #999)';
					input.addEventListener('focus', () => {
						input.style.color = '';
						input.value = '';
						this.$emit('input', '');
					}, { once: true });
				}, 0);
			}
		});
	}
};
