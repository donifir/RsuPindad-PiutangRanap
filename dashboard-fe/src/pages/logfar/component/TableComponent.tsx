import { formatRupiah } from '@/components/FormatRupiah'
import React, { FC, useRef } from 'react'
import { useDownloadExcel } from 'react-export-table-to-excel'
type Props = {
  data: any,
  totalTotalRetus: any,
  totalTotalPemakaian: any,
  totalTotalSaldoAkhir: any,
}


const TableComponent: FC<Props> = (props) => {
  const tableRef = useRef(null);
  const { onDownload } = useDownloadExcel({
    currentTableRef: tableRef.current,
    filename: 'Users table',
    sheet: 'Users'
  })

  return (
    <div>
      <p className='text-[12px] text-[#8E9BAE]' onClick={onDownload}>Export Excel </p>

      <table className="w-full flex flex-wrap table" ref={tableRef}>
        <thead>
          <tr>
            <th colSpan={5} className='text-center border bg-slate-300'>Data Barang</th>
            <th colSpan={3} className='text-center border bg-slate-300'>Saldo Awal</th>
            <th colSpan={2} className='text-center border bg-slate-300'>Penerimaan</th>
            <th colSpan={2} className='text-center border bg-slate-300'>Retur</th>
            <th colSpan={2} className='text-center border bg-slate-300'>Pengeluaran</th>
            <th colSpan={3} className='text-center border bg-slate-300'>Saldo Akhir</th>
          </tr>
          <tr>
            <th className='border bg-slate-300' >No</th>
            <th className='border bg-slate-300' >Kode</th>
            <th className='border bg-slate-300' >Nama Barang</th>
            <th className='border bg-slate-300' >Satuan</th>
            <th className='border bg-slate-300' >Kategori</th>
            <th className='border bg-slate-300' >Qty Awal</th>
            <th className='border bg-slate-300' >Harsat</th>
            <th className='border bg-slate-300' >Jumlah Harga</th>
            <th className='border bg-slate-300' >Qty</th>
            <th className='border bg-slate-300' >Jumlah Harga</th>
            <th className='border bg-slate-300' >Qty</th>
            <th className='border bg-slate-300' >Jumlah Harga</th>
            <th className='border bg-slate-300' >Qty</th>
            <th className='border bg-slate-300' >Jumlah Harga</th>
            <th className='border bg-slate-300' >Qty</th>
            <th className='border bg-slate-300' >Harsat</th>
            <th className='border bg-slate-300' >Jumlah Harga</th>
          </tr>
        </thead>
        <tbody>
          {/* row 1 */}
          {props.data
            .map((dataPenerimaans: any, index: any) =>
            (
              <tr key={index}>
                <td className='border text-xs'>{index + 1}</td>
                <td className='border text-xs'>{dataPenerimaans.kode_brng}</td>
                <td className='border text-xs'>{dataPenerimaans.nama_brng}</td>
                <td className='border text-xs'>{dataPenerimaans.satuan}</td>
                <td className='border text-xs'>{dataPenerimaans.jenisbarang}</td>
                <td className='border text-xs text-end'>{formatRupiah(dataPenerimaans.qty_saldo_awal)}</td>
                <td className='border text-xs text-end' >{formatRupiah(dataPenerimaans.harsat_saldo_awal)}</td>
                <td className='border text-xs text-end' >{formatRupiah(dataPenerimaans.nilai_saldo_awal)}</td>
                <td className='border text-xs text-end' >{formatRupiah(dataPenerimaans.qty_penerimaan)}</td>
                <td className='border text-xs text-end' >{formatRupiah(dataPenerimaans.total_penerimaan)}</td>
                <td className='border text-xs text-end' >{formatRupiah(dataPenerimaans.qty_retur)}</td>
                <td className='border text-xs text-end' >{formatRupiah(dataPenerimaans.qty_retur && dataPenerimaans.qty_penerimaan
                  ? dataPenerimaans.total_penerimaan / dataPenerimaans.qty_penerimaan * dataPenerimaans.qty_retur
                  : dataPenerimaans.qty_retur * dataPenerimaans.harsat_saldo_awal)}</td>
                <td className='border text-xs text-end' >{formatRupiah(dataPenerimaans.qty_pengeluaran)}</td>
                <td className='border text-xs text-end' >{formatRupiah(!!dataPenerimaans.qty_pengeluaran ? (dataPenerimaans.harsat_saldo_awal) * (dataPenerimaans.qty_pengeluaran) : '')}</td>
                <td className='border text-xs text-end'>
                  {formatRupiah(
                    (!!dataPenerimaans.qty_saldo_awal ? dataPenerimaans.qty_saldo_awal : 0)
                    + (!!dataPenerimaans.qty_penerimaan ? dataPenerimaans.qty_penerimaan : 0)
                    + (!!dataPenerimaans.qty_retur ? dataPenerimaans.qty_retur : 0)
                    - (!!dataPenerimaans.qty_pengeluaran ? dataPenerimaans.qty_pengeluaran : 0)
                  )}
                </td>

                <td className='border text-xs text-end'>
                  {formatRupiah(
                    (
                      (dataPenerimaans.nilai_saldo_awal ? dataPenerimaans.nilai_saldo_awal : 0)
                      +
                      (dataPenerimaans.total_penerimaan ? dataPenerimaans.total_penerimaan : 0)
                    ) / (
                      (dataPenerimaans.qty_saldo_awal ? dataPenerimaans.qty_saldo_awal : 0)
                      +
                      (dataPenerimaans.qty_penerimaan ? dataPenerimaans.qty_penerimaan : 0)
                    )
                  )
                  }
                </td>
                <td className='border text-xs text-end'>
                  {formatRupiah(
                    (
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
                    ))}
                </td>
              </tr>
            ))}
        </tbody>
        <thead>
          <tr>
            <th className='border bg-slate-300' ></th>
            <th className='border bg-slate-300' ></th>
            <th className='border bg-slate-300' >Total</th>
            <th className='border bg-slate-300' ></th>
            <th className='border bg-slate-300' ></th>
            <th className='border bg-slate-300' ></th>
            <th className='border bg-slate-300' ></th>
            <th className='border bg-slate-300 text-end' >{formatRupiah(props.data.reduce((acc: any, data: any) => acc + (data.nilai_saldo_awal || 0), 0))}</th>
            <th className='border bg-slate-300' ></th>
            <th className='border bg-slate-300 text-end' >{formatRupiah(props.data.reduce((acc: any, data: any) => acc + (data.total_penerimaan || 0), 0))}</th>
            <th className='border bg-slate-300' > </th>
            <th className='border bg-slate-300 text-end' >{formatRupiah(props.totalTotalRetus)}</th>
            <th className='border bg-slate-300' ></th>
            <th className='border bg-slate-300 text-end' > {formatRupiah(props.totalTotalPemakaian)}</th>
            <th className='border bg-slate-300' ></th>
            <th className='border bg-slate-300' ></th>
            <th className='border bg-slate-300 text-end' >{formatRupiah(props.totalTotalSaldoAkhir)}</th>
          </tr>
        </thead>
      </table>
    </div>
  )
}

export default TableComponent