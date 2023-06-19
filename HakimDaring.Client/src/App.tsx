import { Route, Routes } from 'react-router-dom'
import HalamanIndex from './view/Autentikasi/HalamanIndex'
import HalamanMasuk from './view/Autentikasi/HalamanMasuk'
import HalamanDaftar from './view/Autentikasi/HalamanDaftar'
import HalamanBuatSoal from './view/Soal/HalamanBuatSoal'
import HalamanUbahSoal from './view/Soal/HalamanUbahSoal'
import HalamanJelajah from './view/Dashboard/HalamanJelajah'
import HalamanPengerjaan from './view/Pengerjaan/HalamanPengerjaan'
import HalamanDiskusi from './view/Forum/HalamanDiskusi'
import HalamanHasilPengerjaan from './view/Pengerjaan/HalamanHasilPengerjaan'
import HalamanDaftarPengerjaan from './view/Pengerjaan/HalamanDaftarPengerjaan'
import HalamanProfile from './view/Profile/HalamanProfile'


function App() {

  return (
    <>
      <Routes>
        <Route path='/' element={<HalamanIndex />}></Route>
        <Route path='/profile' element={<HalamanProfile />}></Route>
        <Route path='/masuk' element={<HalamanMasuk />}></Route>
        <Route path='/daftar' element={<HalamanDaftar />}></Route>
        <Route path='/buat-soal' element={<HalamanBuatSoal />}></Route>
        <Route path='/edit-soal/:id_soal' element={<HalamanUbahSoal />}></Route>
        <Route path='/jelajah' element={<HalamanJelajah />}></Route>
        <Route path='/soal/:id_soal/pengerjaan' element={<HalamanPengerjaan />}></Route>
        <Route path='/soal/:id_soal/diskusi' element={<HalamanDiskusi />}></Route>
        <Route path='/soal/:id_soal/hasil' element={<HalamanDaftarPengerjaan />}></Route>
        <Route path='/pengerjaan/:id_pengerjaan' element={<HalamanHasilPengerjaan />}></Route>
      </Routes>
    </>
  )
}

export default App
