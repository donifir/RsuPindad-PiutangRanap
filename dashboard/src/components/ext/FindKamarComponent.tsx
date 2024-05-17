import { Console } from 'console';
import React, { FC, } from 'react'
import { formatRupiah } from '../FormatRupiah';
type Props = {
  data: any;
  norawat: any;
}

const FindKamarComponent: FC<Props> = (props) => {
  const filteredData = props.data.filter((item:any) => item.norawat=== props.norawat);
  const sum = filteredData.reduce((accumulator:any, item:any) => {
    return accumulator + item.biaya;
  }, 0);  
  
  return sum
}

export default FindKamarComponent