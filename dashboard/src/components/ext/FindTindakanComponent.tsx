import { Console } from 'console';
import React, { FC, } from 'react'
import { formatRupiah } from '../FormatRupiah';
type Props = {
  layananDrPr: any;
  layananDr: any;
  layananPr: any;
  umum: any;
  inapDr: any;
  inapDrPr: any;
  norawat: any;
}

const FindTindakanComponent: FC<Props> = (props) => {
  const filteredLayananDrPr = props.layananDrPr.filter((item:any) => item.no_rawat=== props.norawat);
  const sumLayananDrPr = filteredLayananDrPr.reduce((accumulator:any, item:any) => {
    return accumulator + item.biaya_rawat;
  }, 0);

  const filteredLayananDr = props.layananDr.filter((item:any) => item.no_rawat=== props.norawat);
  const sumLayananDr = filteredLayananDr.reduce((accumulator:any, item:any) => {
    return accumulator + item.biaya_rawat;
  }, 0);

  const filteredLayananPr = props.layananPr.filter((item:any) => item.no_rawat=== props.norawat);
  const sumLayananPr = filteredLayananPr.reduce((accumulator:any, item:any) => {
    return accumulator + item.biaya_rawat;
  }, 0);

  const filteredUmum = props.umum.filter((item: any) => item.no_rawat === props.norawat);
  const sumUmum = filteredUmum.reduce((accumulator: any, item: any) => {
    return accumulator + item.biaya_rawat;
  }, 0);

  const filteredInapDr = props.inapDr.filter((item: any) => item.no_rawat === props.norawat);
  const sumInapDr = filteredInapDr.reduce((accumulator: any, item: any) => {
    return accumulator + item.biaya_rawat;
  }, 0);

  const filteredInapDrPr = props.inapDrPr.filter((item: any) => item.no_rawat === props.norawat);
  const sumInapDrPr = filteredInapDrPr.reduce((accumulator: any, item: any) => {
    return accumulator + item.biaya_rawat;
  }, 0);


  return (
        sumLayananDrPr +
        sumLayananDr +
        sumLayananPr +
        sumUmum +
        sumInapDr+ 
        sumInapDrPr
        )
}

export default FindTindakanComponent