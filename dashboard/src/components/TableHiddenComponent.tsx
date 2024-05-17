import React, { FC, useEffect, useRef, useState } from 'react'
import { DownloadTableExcel, useDownloadExcel } from 'react-export-table-to-excel'
import { formatRupiah } from './FormatRupiah';
import axios from 'axios';

type Props = {
  tanggal: string
}

const TableHiddenComponent: FC<Props> = ({ tanggal }) => {
  const [totalsBpjs, setTotalsBpjs] = useState<any>([]);
  const [totalsCob, setTotalsCob] = useState<any>([]);
  const [totalsUmum, setTotalsUmum] = useState<any>([]);
  const [totalsKon, setTotalsKon] = useState<any>([]);
  const [totalsKetenagakerjaan, setKetenagaKerjaan] = useState<any>([]);
  const tableRef = useRef(null);

  // totalbpjs
  async function getDataTotalBpjs() {
    try {
      const response = await axios.get(`/total-data-ranap/bpjs/${tanggal}`);
      setTotalsBpjs(response.data.data);
      console.log(response.data.data);
    } catch (error) {
      console.error(error);
    }
  }

  async function getDataTotalUmum() {
    try {
      const response = await axios.get(`/total-data-ranap/umum/${tanggal}`);
      setTotalsUmum(response.data.data);
      console.log(response.data.data);
    } catch (error) {
      console.error(error);
    }
  }

  async function getDataTotalCob() {
    try {
      const response = await axios.get(`/total-data-ranap/cob/${tanggal}`);
      setTotalsCob(response.data.data);
      console.log(response.data.data);
    } catch (error) {
      console.error(error);
    }
  }

  async function getDataTotalKon() {
    try {
      const response = await axios.get(`/total-data-ranap/kon/${tanggal}`);
      setTotalsKon(response.data.data);
      console.log(response.data.data);
    } catch (error) {
      console.error(error);
    }
  }

  async function getDataTotalKetenagaKerjaan() {
    try {
      const response = await axios.get(`/total-data-ranap/ketenagakerjaan/${tanggal}`);
      setKetenagaKerjaan(response.data);
      console.log(response.data.data);
    } catch (error) {
      console.error(error);
    }
  }

  useEffect(() => {
    getDataTotalKetenagaKerjaan()
    getDataTotalBpjs()
    getDataTotalUmum()
    getDataTotalCob()
    getDataTotalKon()
  }, [String(tanggal)])


  const { onDownload } = useDownloadExcel({
    currentTableRef: tableRef.current,
    filename: 'Users table',
    sheet: 'Users'
  })

  const totalBpjs = totalsBpjs.total ? totalsBpjs.total : 0;
  const totalKetenagakerjaan = totalsKetenagakerjaan.total ? totalsKetenagakerjaan.total : 0;
  const totalUmum = totalsUmum.total ? totalsUmum.total : 0;
  const totalCob = totalsCob.total ? totalsCob.total :0;
  const totalCon = totalsKon.total ? totalsKon.total :0;
  const total = totalBpjs + totalKetenagakerjaan + totalUmum+totalCob+totalCon;

  return (
    <div className="verflow-x-auto">
      {totalsBpjs.registrasi ?
        <button onClick={onDownload} className='btn btn-outline btn-warning btn-sm lowercase mx-4'> Export Excel Rekap </button>
        : ""}
      <div className="overflow-x-auto">
        <table className="table table-xs" ref={tableRef}>
          <thead>
            <tr>
              <th></th>
              <th>Nama Penjamin</th>
              <th>Registrasi</th>
              <th>Tindakan</th>
              <th>Obat</th>
              <th>Laborat</th>
              <th>Radiologi</th>
              <th>Kamar</th>
              <th>Operasi</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th>1</th>
              <td>BPJS Kesehatan</td>
              <td>{totalsBpjs.registrasi}</td>
              <td>{totalsBpjs.tindakans}</td>
              <td>{totalsBpjs.obat}</td>
              <td>{totalsBpjs.laboratorium}</td>
              <td>{totalsBpjs.radiologi}</td>
              <td>{totalsBpjs.kamar}</td>
              <td>{totalsBpjs.operasi}</td>
              <td>{totalsBpjs.total}</td>
            </tr>
            <tr>
              <th>2</th>
              <td>BPJS Ketenagakerjaan</td>
              <td>{totalsKetenagakerjaan.registrasi}</td>
              <td>{totalsKetenagakerjaan.tindakans}</td>
              <td>{totalsKetenagakerjaan.obat}</td>
              <td>{totalsKetenagakerjaan.laboratorium}</td>
              <td>{totalsKetenagakerjaan.radiologi}</td>
              <td>{totalsKetenagakerjaan.kamar}</td>
              <td>{totalsKetenagakerjaan.operasi}</td>
              <td>{totalsKetenagakerjaan.total}</td>
            </tr>
            <tr>
              <th>3</th>
              <td>Umum</td>
              <td>{totalsUmum.registrasi}</td>
              <td>{totalsUmum.tindakans}</td>
              <td>{totalsUmum.obat}</td>
              <td>{totalsUmum.laboratorium}</td>
              <td>{totalsUmum.radiologi}</td>
              <td>{totalsUmum.kamar}</td>
              <td>{totalsUmum.operasi}</td>
              <td>{totalsUmum.total}</td>
            </tr>
            <tr>
              <th>4</th>
              <td>COB</td>
              <td>{totalsCob.registrasi}</td>
              <td>{totalsCob.tindakans}</td>
              <td>{totalsCob.obat}</td>
              <td>{totalsCob.laboratorium}</td>
              <td>{totalsCob.radiologi}</td>
              <td>{totalsCob.kamar}</td>
              <td>{totalsCob.operasi}</td>
              <td>{totalsCob.total}</td>
            </tr>
            <tr>
              <th>5</th>
              <td>Kontraktor</td>
              <td>{totalsKon.registrasi}</td>
              <td>{totalsKon.tindakans}</td>
              <td>{totalsKon.obat}</td>
              <td>{totalsKon.laboratorium}</td>
              <td>{totalsKon.radiologi}</td>
              <td>{totalsKon.kamar}</td>
              <td>{totalsKon.operasi}</td>
              <td>{totalsKon.total}</td>
            </tr>

            <tr>
              <th></th>
              <td>Total</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td>{total}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  )
}

export default TableHiddenComponent