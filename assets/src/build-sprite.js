#!/usr/bin/env node
/**
 * build-sprite.js — SVG Sprite Generator für pwicon
 *
 * Usage (von überall ausführbar):
 *   node assets/src/build-sprite.js --set remix
 *   node assets/src/build-sprite.js --set custom
 *
 * Input:  assets/src/{set}/
 * Output: assets/icons/{set}.svg
 */

const fs   = require('fs');
const path = require('path');

// Paths relative to this script file — works from any working directory
const srcDir = __dirname;
const outDir = path.join(__dirname, '../icons/');

// Parse CLI args
const args = process.argv.slice(2);
const get  = (flag) => { const i = args.indexOf(flag); return i !== -1 ? args[i + 1] : null; };

const set   = get('--set') || 'custom';
const input = get('--input') || path.join(srcDir, set);
const outFile = path.join(outDir, `${set}.svg`);

if (!fs.existsSync(input)) {
	console.error(`Input directory not found: ${input}`);
	process.exit(1);
}

// Ensure output directory exists
fs.mkdirSync(outDir, { recursive: true });

// Collect SVG files recursively
function collectSvgs(dir) {
	let result = [];
	for (const entry of fs.readdirSync(dir, { withFileTypes: true })) {
		const full = path.join(dir, entry.name);
		if (entry.isDirectory()) {
			result = result.concat(collectSvgs(full));
		} else if (entry.name.endsWith('.svg')) {
			result.push(full);
		}
	}
	return result;
}

const files = collectSvgs(input).sort();

if (files.length === 0) {
	console.error(`No SVG files found in: ${input}`);
	process.exit(1);
}

let symbols = '';
let count = 0;

for (const file of files) {
	const id      = path.basename(file, '.svg');
	const content = fs.readFileSync(file, 'utf8');

	// Extract viewBox and fill from outer <svg>
	const vbMatch   = content.match(/viewBox="([^"]+)"/);
	const viewBox   = vbMatch ? vbMatch[1] : '0 0 24 24';
	const svgTag    = content.match(/<svg([^>]*)>/)?.[1] || '';
	const fillMatch = svgTag.match(/\bfill="([^"]+)"/);
	const fill      = fillMatch ? fillMatch[1] : 'currentColor';

	// Extract inner content (strip outer <svg> tags)
	const inner = content
		.replace(/<\?xml[^>]*\?>/g, '')
		.replace(/<!--[\s\S]*?-->/g, '')
		.replace(/<svg[^>]*>/g, '')
		.replace(/<\/svg>/g, '')
		.trim();

	symbols += `  <symbol id="${id}" viewBox="${viewBox}" fill="${fill}">${inner}</symbol>\n`;
	count++;
}

const sprite = `<svg xmlns="http://www.w3.org/2000/svg" style="display:none">\n${symbols}</svg>\n`;
fs.writeFileSync(outFile, sprite, 'utf8');

console.log(`✓ ${count} icons → ${outFile}`);
