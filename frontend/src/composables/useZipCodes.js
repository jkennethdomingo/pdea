import zipcodes from '@/assets/json/zipcode.json';

export default function useZipCodes() {
  const findZipCode = (zipcode) => {
    return zipcodes[zipcode] || null;
  };

  const findLocationByZipCode = (location) => {
    return Object.keys(zipcodes).find((zipcode) => {
      const value = zipcodes[zipcode];
      if (typeof value === 'string') {
        return value.toLowerCase() === location.toLowerCase();
      }
      return value.map(v => v.toLowerCase()).includes(location.toLowerCase());
    }) || null;
  };

  return {
    findZipCode,
    findLocationByZipCode
  };
}
