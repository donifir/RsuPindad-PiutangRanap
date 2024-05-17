
import ComponentButtonOnly from "@/components/ComponentButtonOnly";
import axios from "axios";
import { useRouter } from "next/router";
import React, { FC, useState } from "react";
import { MdOutlineDelete } from "react-icons/md";
import { toast } from 'react-toastify';
const notify = () => toast.success("Berhasil, Data berhasil dihapus!");

type Props = {
  id: any,
  label: any,
}
const DeleteSatuDataComponent: FC<Props> = (props) => {
  const [modal, setModal] = useState(false);

  function handleChange() {
    setModal(!modal);
  }
  const router = useRouter();

  const sendData = () => {

    axios.delete(`/data-adjust/barang/delete/${props.id}`)
      .then(function (response) {
        // handle success
        router.push("/logfar/adjust")
        notify()
        console.log(response);
      })
      .catch(function (error) {
        // handle error
        console.log(error);
      })
  }

  return (
    <div>
      <div onClick={handleChange}>
        <ComponentButtonOnly label="Delete" icon={<MdOutlineDelete />} bg="bg-red-800" styleText="text-slate-100" />
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
            <h3 className="font-bold text-lg ">Delete</h3>
            <label className="btn btn-sm btn-circle absolute right-2 top-2" onClick={handleChange}>✕</label>
          </div>
          <div>Apakah anda yakin untuk menghapus data {props.label}</div>
          <div className="modal-action ">
            <button type="button" className="btn btn-sm bg-red-800" onClick={sendData}>
              Delete
            </button>
          </div>
        </div>
      </div>
    </div>
  );
};

export default DeleteSatuDataComponent;