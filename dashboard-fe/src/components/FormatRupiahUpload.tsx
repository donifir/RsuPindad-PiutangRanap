export const formatRupiahUpload = (number: any) => {
  
  const data =Math.round(number)

  return (data?data:0);
};