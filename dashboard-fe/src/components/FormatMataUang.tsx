
export const FormatMataUang=(number: any) => {
  const formatter = new Intl.NumberFormat('id-ID',
  );
  const data =Math.round(number)

  return formatter.format(data>1?data:0);
};