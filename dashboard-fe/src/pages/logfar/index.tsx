
import axios from 'axios'
import React, { useEffect, useRef, useState } from 'react'
import 'react-datepicker/dist/react-datepicker.css';
import { format } from 'date-fns';
// import DatePicker, { CalendarContainer } from 'react-datepicker';
import DatePicker from "react-datepicker";
import { useDownloadExcel } from 'react-export-table-to-excel';
// import { formatRupiah } from '@/components/FormatRupiah';
import { useMemo } from 'react';
import Link from 'next/link';
import { formatRupiah } from '@/components/FormatRupiah';
import TableComponent from './component/TableComponent';
import ModalImportComponent from './component/ModalImportComponent';

export const header = {
  headers: {
    'Content-Type': 'multipart/form-data',
    Accept: 'application/json',
  },
};

const index = () => {

  const [data, setData] = useState<any>([]);
  const [loading, setLoading] = useState<boolean>(false);
  const [error, setError] = useState<boolean>(false);
  const [tanggalMulai, setTanggalMulai] = useState<any>('');
  const [tanggalSelsai, setTanggalSelsai] = useState<any>('');
  const [bulan, setBulan] = useState<any>('');
  const [selectedDateMulai, setSelectedDateMulai] = useState<any>(null);
  const [selectedDateSelesai, setSelectedDateSelesai] = useState<any>(null);

  const [totalTotalPemakaian, setTotalTotalPemakaian] = useState(0);
  const [totalTotalRetus, setTotalTotalRetur] = useState(0);
  const [totalTotalSaldoAkhir, setTotalTotalSaldoAkhir] = useState(0);

  const handleDateChangeMulai = (date: Date | null) => {
    setSelectedDateMulai(date);
    if (date) {
      const formattedDate = format(date, 'yyyy-MM-dd'); // Format the date
      setTanggalMulai(formattedDate)
      console.log(tanggalMulai); // Output the formatted date
    }
  };
  const handleDateChangeSelesai = (date: Date | null) => {
    setSelectedDateSelesai(date);
    if (date) {
      const formattedDate = format(date, 'yyyy-MM-dd'); // Format the date
      setTanggalSelsai(formattedDate)
      console.log(tanggalSelsai); // Output the formatted date
    }
  };

  // create array

  const onSubmits = (e: any) => {
    e.preventDefault();
    setLoading(true)

    console.log(tanggalMulai, 'tanggal mulai')
    console.log(tanggalSelsai, 'tanggal selesai')
    // console.log(tanggalSelsai,'tanggal selesai')
    const formData = new FormData()
    formData.append('tanggal_mulai', tanggalMulai)
    formData.append('tanggal_selesai', tanggalSelsai)
    formData.append('nama_bulan', bulan)


    axios.post('/pull-data', formData, header)
      .then(function (response) {
        console.log(response.data);
        setData(response.data.data)
        setLoading(false);

      })
      .catch(function (error) {
        setLoading(false);
        setError(true)
        console.log(error);
      });
  }

  const total = useMemo(() => {
    let tempTotalPemakaian = 0;
    let tempTotalRetur = 0;
    let tempSaldoAkhir = 0;

    data.forEach((dataPenerimaans: any) => {

      tempTotalPemakaian += (!!dataPenerimaans.qty_pengeluaran ? (dataPenerimaans.harsat_saldo_awal) * (dataPenerimaans.qty_pengeluaran) : '')|| 0;
      tempTotalRetur += dataPenerimaans.qty_retur && dataPenerimaans.qty_penerimaan
        ? dataPenerimaans.total_penerimaan / dataPenerimaans.qty_penerimaan * dataPenerimaans.qty_retur
        : dataPenerimaans.qty_retur * dataPenerimaans.harsat_saldo_awal || 0;
      tempSaldoAkhir += (
        (!!dataPenerimaans.qty_saldo_awal ? dataPenerimaans.qty_saldo_awal : 0)
        + (!!dataPenerimaans.qty_penerimaan ? dataPenerimaans.qty_penerimaan : 0)
        + (!!dataPenerimaans.qty_retur ? dataPenerimaans.qty_retur : 0)
        - (!!dataPenerimaans.qty_pengeluaran ? dataPenerimaans.qty_pengeluaran : 0)
      )
        * (
          (
            (dataPenerimaans.nilai_saldo_awal ? dataPenerimaans.nilai_saldo_awal : 0)
            +
            (dataPenerimaans.total_penerimaan ? dataPenerimaans.total_penerimaan : 0)
          ) / (
            (dataPenerimaans.qty_saldo_awal ? dataPenerimaans.qty_saldo_awal : 0)
            +
            (dataPenerimaans.qty_penerimaan ? dataPenerimaans.qty_penerimaan : 0)
          )
        ) || 0;

    });
    setTotalTotalPemakaian(tempTotalPemakaian);
    setTotalTotalRetur(tempTotalRetur);
    setTotalTotalSaldoAkhir(tempSaldoAkhir)
    return null;
  }, [data]);

  const [datas, setdatas] = useState<any>([]);
  async function getDataAdjust() {
    try {
      const response = await axios.get('/data-adjust');
      setdatas(response.data.data)
      console.log(response);
    } catch (error) {
      console.error(error);
    }
  }

  useEffect(() => {
    getDataAdjust()
  }, [])

  return (
    <div>
      <div className='flex flex-row gap-3  pt-4 '>
        <div className='flex flex-row justify-between items-center w-full'>
          <div>
            {/* <p onClick={() => console.log(newArray)}>console log</p> */}
            <p className='text-2xl'>Your Personal Learning : {bulan}</p>
            {/* <p className='text-[12px] text-[#8E9BAE]'>Based on yoru preferences</p> */}
            <ModalImportComponent data={data} />
          </div>
          <div>
            <form onSubmit={onSubmits} className='flex-row flex items-center'>
              <div className="flex flex-row mr-5">
                <div className="customDatePickerWidth">
                  <DatePicker
                    selected={selectedDateMulai}
                    onChange={handleDateChangeMulai}
                    dateFormat="yyyy-MM-dd"
                    placeholderText="Masukan Tanggal Mulai"
                    className="input input-bordered w-[100%] min-w-max"
                  />
                </div>
              </div>
              <div className="flex flex-row mr-5">
                <div className="customDatePickerWidth ">
                  <DatePicker
                    selected={selectedDateSelesai}
                    onChange={handleDateChangeSelesai}
                    dateFormat="yyyy-MM-dd"
                    placeholderText="Sampai Dengan Tanggal"
                    className="input input-bordered w-[100%] min-w-max"
                  />
                </div>
              </div>
              <select
                value={bulan}
                onChange={(e: any) => setBulan(e.target.value)}
                id="countries"
                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 input-md mr-2">
                <option >pilih bulan</option>
                {datas.map((datast: any, index: any) => (
                  <option value={datast.nama_bulan}>{datast.nama_bulan}</option>
                ))}

              </select>
              <button className="btn btn-success mr-5" type={loading ? 'button' : 'submit'}>{loading ? "Loading" : 'Submit'}</button>
            </form>
          </div>
        </div>
      </div>
      <div className='bg-white bg-opacity-70  mt-4 rounded-md shadow-xl py-2'>
        <div className="overflow-x-auto">
          <TableComponent data={data} totalTotalRetus={totalTotalRetus} totalTotalPemakaian={totalTotalPemakaian} totalTotalSaldoAkhir={totalTotalSaldoAkhir} />
        </div>
      </div>
    </div>
  )
}

export default index