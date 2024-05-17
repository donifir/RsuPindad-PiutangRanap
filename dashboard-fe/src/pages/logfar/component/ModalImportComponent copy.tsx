
import ComponentButtonOnly from "@/components/ComponentButtonOnly";
import TextInputComponent from "@/components/input/TextInputComponent";
import axios from "axios";
import { useRouter } from "next/router";
import React, { FC, SyntheticEvent, useState } from "react";
import { MdOutlineDelete } from "react-icons/md";
import { toast } from 'react-toastify';
import { header } from "..";
import { formatRupiahUpload } from "@/components/FormatRupiahUpload";
const notify = () => toast.success("Berhasil, Data berhasil dihapus!");

type Props = {
  data: any
}
const ModalImportComponent: FC<Props> = (props) => {
  const [modal, setModal] = useState(false);
  const [namabulan, setNamaBulan] = useState('');
  const [loading, setLoading] = useState<boolean>(false);
  const [dataArray, setdataArray] = useState<any>([])


  function handleChange() {
    setModal(!modal);
  }

  const onSubmits = async(e: SyntheticEvent) => {
    
    e.preventDefault();
    setLoading(true)

    // const newArray = props.data.map((dataPenerimaans: any) => ({
    //   nama_bulan: namabulan,
    //   kode_brng: dataPenerimaans.kode_brng,
    //   nama_brng: dataPenerimaans.nama_brng,
    //   kategori: dataPenerimaans.kategori,
    //   qty_saldo_awal: (formatRupiahUpload
    //     (
    //       (!!dataPenerimaans.qty_saldo_awal ? dataPenerimaans.qty_saldo_awal : 0)
    //       + (!!dataPenerimaans.qty_penerimaan ? dataPenerimaans.qty_penerimaan : 0)
    //       + (!!dataPenerimaans.qty_retur ? dataPenerimaans.qty_retur : 0)
    //       - (!!dataPenerimaans.qty_pengeluaran ? dataPenerimaans.qty_pengeluaran : 0)
    //     )
    //   ),
    //   harsat_saldo_awal: (formatRupiahUpload(
    //     (
    //       (dataPenerimaans.nilai_saldo_awal ? dataPenerimaans.nilai_saldo_awal : 0)
    //       +
    //       (dataPenerimaans.total_penerimaan ? dataPenerimaans.total_penerimaan : 0)
    //     ) / (
    //       (dataPenerimaans.qty_saldo_awal ? dataPenerimaans.qty_saldo_awal : 0)
    //       +
    //       (dataPenerimaans.qty_penerimaan ? dataPenerimaans.qty_penerimaan : 0)
    //     )
    //   )
    //   )
    //   ,
    //   nilai_saldo_awal: (formatRupiahUpload(
    //     (
    //       (!!dataPenerimaans.qty_saldo_awal ? dataPenerimaans.qty_saldo_awal : 0)
    //       + (!!dataPenerimaans.qty_penerimaan ? dataPenerimaans.qty_penerimaan : 0)
    //       + (!!dataPenerimaans.qty_retur ? dataPenerimaans.qty_retur : 0)
    //       - (!!dataPenerimaans.qty_pengeluaran ? dataPenerimaans.qty_pengeluaran : 0)
    //     )
    //     * (
    //       (
    //         (dataPenerimaans.nilai_saldo_awal ? dataPenerimaans.nilai_saldo_awal : 0)
    //         +
    //         (dataPenerimaans.total_penerimaan ? dataPenerimaans.total_penerimaan : 0)
    //       ) / (
    //         (dataPenerimaans.qty_saldo_awal ? dataPenerimaans.qty_saldo_awal : 0)
    //         +
    //         (dataPenerimaans.qty_penerimaan ? dataPenerimaans.qty_penerimaan : 0)
    //       )
    //     ))),
    // }));


    const newArray = props.data.map((dataPenerimaans: any) => {
      const qty_saldo_awal = (!!dataPenerimaans.qty_saldo_awal ? dataPenerimaans.qty_saldo_awal : 0) +
        (!!dataPenerimaans.qty_penerimaan ? dataPenerimaans.qty_penerimaan : 0) +
        (!!dataPenerimaans.qty_retur ? dataPenerimaans.qty_retur : 0) -
        (!!dataPenerimaans.qty_pengeluaran ? dataPenerimaans.qty_pengeluaran : 0);

      const qty_saldo_penerimaan = (!!dataPenerimaans.qty_saldo_awal ? dataPenerimaans.qty_saldo_awal : 0) +
        (!!dataPenerimaans.qty_penerimaan ? dataPenerimaans.qty_penerimaan : 0);

      const harsat_saldo_awal = formatRupiahUpload(
        ((dataPenerimaans.nilai_saldo_awal ? dataPenerimaans.nilai_saldo_awal : 0) +
          (dataPenerimaans.total_penerimaan ? dataPenerimaans.total_penerimaan : 0)) /
        qty_saldo_penerimaan
      );

      const nilai_saldo_awal = formatRupiahUpload(qty_saldo_awal * harsat_saldo_awal);

      return {
        nama_bulan: namabulan,
        kode_brng: dataPenerimaans.kode_brng,
        nama_brng: dataPenerimaans.nama_brng,
        kategori: dataPenerimaans.kategori,
        qty_saldo_awal: formatRupiahUpload(qty_saldo_awal),
        harsat_saldo_awal,
        nilai_saldo_awal
      };
    });

    await setdataArray(newArray)
    console.log(newArray)


    fetch('http://192.168.2.8:8000/api/data-adjust/stored-data', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ newArray }),
    })
    .then(response => response.json())
    .then(data => {
      console.log('Response:', data);
      setLoading(false)
    })
    .catch(error => {
      console.error('Error:', error);
    });

  }


  return (
    <div>
      <div onClick={handleChange}>
        <div className='text-[12px] text-[#8E9BAE]'>
          Jadikan data saldo awal
        </div>
        {/* <ComponentButtonOnly label="Delete" icon={<MdOutlineDelete />} bg="bg-red-800" styleText="text-slate-100" /> */}
      </div>

      <input
        type="checkbox"
        checked={modal}
        onChange={handleChange}
        className="modal-toggle"
      />

      <div className="modal">
        <div className="modal-box w-7/12 max-w-xl">
          <div className="flex flex-row justify-between">
            <h3 className="font-bold text-lg ">Simpan</h3>
            <label className="btn btn-sm btn-circle absolute right-2 top-2" onClick={handleChange}>✕</label>
          </div>
          <div>Apakan anda ingin menyimpan data.? </div>
          <form onSubmit={onSubmits}>
            <TextInputComponent
              disabled={false}
              label='Masukan Nama bulan'
              value={namabulan}
              onChange={(e: any) => setNamaBulan(e.target.value)}
              error={''}
            />
            <button className="mt-3 btn btn-success mr-5" type={loading ? 'button' : 'submit'}>{loading ? "Loading" : 'Simpan'}</button>

          </form>
        </div>
      </div>
    </div>
  );
};

export default ModalImportComponent;