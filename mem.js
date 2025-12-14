const crypto = require('crypto');

// Get target memory from command line (default to 512MB if not set)
const targetMB = 2000;
const chunkSizeMB = 10; 
const chunks = [];

const sleep = (ms) => new Promise((resolve) => setTimeout(resolve, ms));

async function main() {
  console.log(`Starting: Aiming to consume ~${targetMB} MB of RAM...`);

  // --- Phase 1: Allocation ---
  let currentMB = 0;
  while (currentMB < targetMB) {
    // Allocating a Buffer is more precise than a standard Array
    // 'Buffer.alloc' initializes memory with zeros (ensuring it's actually claimed)
    const chunk = Buffer.alloc(chunkSizeMB * 1024 * 1024);
    
    // Fill with some random data so it's not easily compressible by OS
    crypto.randomFillSync(chunk, 0, 1024); 
    
    chunks.push(chunk);
    currentMB += chunkSizeMB;
    
    // Log every 100MB
    if (currentMB % 100 === 0) {
      console.log(`Allocated: ${currentMB} MB`);
    }
    
    // Small pause to be gentle on CPU during allocation
    await sleep(20);
  }

  console.log(`\nReached target size! Holding ${currentMB} MB.`);
  console.log("Starting Read/Write stress test (Press Ctrl+C to stop)...\n");

  // --- Phase 2: Read/Write Stress ---
  let iterations = 0;
  
  while (true) {
    const startTime = Date.now();
    
    // Iterate over every chunk to touch the memory pages
    for (let i = 0; i < chunks.length; i++) {
      const chunk = chunks[i];
      
      // WRITE: Change a byte at a random location
      // This marks the memory page as "dirty", forcing the OS to keep it valid
      const randIndex = Math.floor(Math.random() * chunk.length);
      chunk[randIndex] = (chunk[randIndex] + 1) % 255;

      // READ: Simple check to ensure we can access it
      const val = chunk[randIndex]; 
    }

    iterations++;
    
    // Log status every ~5 seconds (assuming 200ms sleep)
    if (iterations % 25 === 0) {
      const used = process.memoryUsage().rss / 1024 / 1024;
      console.log(`[Cycle ${iterations}] Active. RSS Memory: ${Math.round(used)} MB`);
    }

    // Sleep 200ms between cycles
    await sleep(200);
  }
}

main().catch(console.error);
