// lazyLoadData function returns a Promise
export async function lazyLoadData(jsonFilePath) {
  const module = await import(/* webpackChunkName: "json-data" */ `@/assets/json/${jsonFilePath}`);
  return module.default;
}

