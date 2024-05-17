export const formatRupiah = (number: any) => {
  const formatter = new Intl.NumberFormat('id-ID',
    // {
    //   style: 'currency',
    //   currency: 'IDR',
    // }
  );
  const data =Math.round(number)

  return formatter.format(data?data:0);
};