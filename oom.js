// A simple helper to pause execution
const sleep = (ms) => new Promise((resolve) => setTimeout(resolve, ms));

async function consumeMemory() {
  const hog = [];
  let counter = 0;

  while (true) {
    // 1. Allocate memory (approx 10MB strings)
    // Note: The string "memory-hog" takes more bytes, but the array length is the main factor.
    hog.push(new Array(10000000).fill("memory-hog")); 
    
    counter++;
    
    // Log progress so you can see it working
    const used = process.memoryUsage().heapUsed / 1024 / 1024;
    console.log(`Step ${counter}: Heap used approx ${Math.round(used)} MB`);

    // 2. Pause for 200ms to let the Event Loop breathe
    await sleep(200);
  }
}

consumeMemory();
