import { readFileSync, writeFileSync } from 'fs';
import { PNG } from 'pngjs';

const inputPath = 'z:/CODES!!!! SSD/PHP Enverga/enverga-pass/public/images/seal.png';
const outputPath = 'z:/CODES!!!! SSD/PHP Enverga/enverga-pass/public/images/seal-transparent.png';

const buffer = readFileSync(inputPath);
const png = PNG.sync.read(buffer);

for (let y = 0; y < png.height; y++) {
  for (let x = 0; x < png.width; x++) {
    const idx = (png.width * y + x) << 2;
    const r = png.data[idx];
    const g = png.data[idx + 1];
    const b = png.data[idx + 2];

    // If pixel is near white background (RGB > 220)
    if (r > 215 && g > 215 && b > 215) {
      png.data[idx + 3] = 0; // Make fully transparent
    }
  }
}

const options = { fill: false };
const transparentBuffer = PNG.sync.write(png, options);
writeFileSync(outputPath, transparentBuffer);
console.log('Background removed successfully!');
