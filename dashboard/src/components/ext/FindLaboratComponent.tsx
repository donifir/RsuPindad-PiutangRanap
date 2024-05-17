import { Console } from 'console';
import React, { FC, } from 'react'
import { formatRupiah } from '../FormatRupiah';
type Props = {
  laborat1: any;
  laborat2: any;
  norawat: any;
}

const FindLaboratComponent: FC<Props> = (props) => {
  const filteredDataLaborat1 = props.laborat1.filter((item:any) => item.no_rawat=== props.norawat);
  const sum = filteredDataLaborat1.reduce((accumulator:any, item:any) => {
    return accumulator + item.biaya;
  }, 0);  

  const filteredDataLaborat2 = props.laborat2.filter((item:any) => item.no_rawat=== props.norawat);
  const sum2 = filteredDataLaborat2.reduce((accumulator:any, item:any) => {
    return accumulator + item.biaya_item;
  }, 0); 
  return sum+sum2
}

export default FindLaboratComponent