import { useEffect, useState } from 'react'
import { Button, Container, Row, Col, Form, Table } from 'react-bootstrap'
import { useNavigate, useParams } from 'react-router-dom';
import Header from '../Header';
import RequestAmbilInformasiUser from '../../core/InformasiUser/RequestAmbilInformasiUser';
import BerhasilAmbilInformasiUser from '../../core/Responses/ResponseBerhasil/InformasiUser/BerhasilAmbilInformasiUser';
import RequestEditInformasiUser from '../../core/InformasiUser/RequestEditInformasiUser';
import EditUser from '../../core/InformasiUser/Data/EditUser';
import BerhasilEditInformasiUser from '../../core/Responses/ResponseBerhasil/InformasiUser/BerhasilEditInformasiUser';
import CalendarHeatmap from 'react-calendar-heatmap';
import 'react-calendar-heatmap/dist/styles.css';
import RequestAmbilFrekuensiAktivitas from '../../core/InformasiUser/RequestAmbilFrekuensiAktivitas';
import BerhasilAmbilFrekuensiAktivitas from '../../core/Responses/ResponseBerhasil/InformasiUser/BerhasilAmbilFrekuensiAktivitas';
import RequestAmbilHistoryPengerjaan from '../../core/InformasiUser/RequestAmbilHistoryPengerjaan';
import AmbilHistoryPengerjaan from '../../core/InformasiUser/Data/AmbilHistoryPengerjaan';
import BerhasilAmbilHistoryPengerjaan from '../../core/Responses/ResponseBerhasil/InformasiUser/BerhasilAmbilHistoryPengerjaan';
import ResponsePengerjaanLama from '../../core/Responses/ResponseBerhasil/InformasiUser/ResponsePengerjaanLama';

function HalamanInformasiUser() {

  const navigate = useNavigate()
  const parameterURL = useParams()

  const requestAmbilInformasiUser : RequestAmbilInformasiUser = new RequestAmbilInformasiUser()
  const requestEditInformasiUser : RequestEditInformasiUser = new RequestEditInformasiUser()
  const requestAmbilFrekuensiAktivitas : RequestAmbilFrekuensiAktivitas = new RequestAmbilFrekuensiAktivitas()
  const requestAmbilHistoryPengerjaan : RequestAmbilHistoryPengerjaan = new RequestAmbilHistoryPengerjaan()

  let [halamanDitampilkan, ] = useState<number>(5)
  let [arrayHalaman, setArrayHalaman] = useState<number[]>([])

  let [informasiUser, setInformasiUser] = useState<BerhasilAmbilInformasiUser>({
    id_user : "",
    email : "",
    nama_user : "",
    tanggal_bergabung : ""
  })
  let [idUser, ] = useState<string|null>(localStorage.getItem("id"))
  let [frekuensiAktivitas, setFrekuensiAktivitas] = useState<BerhasilAmbilFrekuensiAktivitas|null>(null)
  let [ambilHistoryPengerjaan, setAmbilHistoryPengerjaan] = useState<AmbilHistoryPengerjaan>({
    halaman : 1,
    idUser : ""
  })
  let [historyPengerjaan, setHistoryPengerjaan] = useState<BerhasilAmbilHistoryPengerjaan|null>(null)

  const pindahHalamanJelajah = () => {
    navigate("/jelajah")
  }

  const ubahNamaUser = (nama : string) => {
    setInformasiUser({...informasiUser, nama_user : nama})
  }

  const simpanDataUser = () => {
    requestEditInformasiUser.execute({
      id_user : informasiUser.id_user,
      nama : informasiUser.nama_user
    } as EditUser, (hasil : any) => {
      if (hasil instanceof BerhasilEditInformasiUser) {
        localStorage.setItem("nama", hasil.namaUser);
        window.location.reload()
      }
    })
  }

  useEffect(() => {
    if (parameterURL.id_user === undefined) {
      pindahHalamanJelajah()
    }

    requestAmbilInformasiUser.execute(parameterURL.id_user!, (hasil : any) => {
      if (hasil instanceof BerhasilAmbilInformasiUser) {
        setInformasiUser(hasil)
      }
    })

    requestAmbilFrekuensiAktivitas.execute(parameterURL.id_user!, (hasil : any) => {
      if (hasil instanceof BerhasilAmbilFrekuensiAktivitas) {
        setFrekuensiAktivitas(hasil)
      }
    })

    setAmbilHistoryPengerjaan({...ambilHistoryPengerjaan, idUser : parameterURL.id_user!})
  }, [])

  useEffect(() => {
    if (ambilHistoryPengerjaan.idUser != "") {
      requestAmbilHistoryPengerjaan.execute(ambilHistoryPengerjaan, (hasil : any) => {
        if (hasil instanceof BerhasilAmbilHistoryPengerjaan) {
          let batasBawah = Math.max(1, hasil.halaman - Math.trunc(halamanDitampilkan / 2))
          let batasAtas = Math.min(hasil.total_halaman, hasil.halaman + Math.trunc(halamanDitampilkan / 2))
          
          let arrayHalamanSementara : number[] = []
          for (let i = batasBawah; i <= batasAtas; i++) {
            arrayHalamanSementara.push(i)
          }
          
          setHistoryPengerjaan(hasil)
          setArrayHalaman(arrayHalamanSementara)
        }
      })
    }
  }, [ambilHistoryPengerjaan])

  return (
    <>
      <Container className='min-vh-100 mw-100 m-0 p-0 d-flex flex-column'>
        <Header />
        <Col className='h-100 justify-content-center'>
          <Row className='m-0 p-0'>
            <p className='text-center m-0 py-3 fs-3 fw-bold mb-3'>
              Informasi User
            </p>
            <Row className='m-0 p-0 d-flex flex-row'>
              <Col xs={12} sm={12} md={12} lg={4} xl={4} className='m-0 p-2'>
                <Row className='m-0 p-0'>
                  <Row className='m-0 p-0 py-1 d-flex flex-row'>
                    <Col xs={6} className='m-0 p-0 d-flex flex-column justify-content-center'>
                      <p className='m-0 p-0 px-2 fs-6 text-end'>Nama:</p>
                    </Col>
                    <Col xs={6} className='m-0 p-0 d-flex flex-column justify-content-center'>
                      {idUser == informasiUser.id_user ?
                        <Form.Control type='text' placeholder="Nama" className='m-2 py-1 text-center fs-6' value={informasiUser.nama_user} onChange={(e) => {ubahNamaUser(e.target.value)}}/>
                        :
                        <p className='m-0 p-0 px-2 fs-6 text-start'>{informasiUser.nama_user}</p>
                      }
                    </Col>
                  </Row>
                  <Row className='m-0 p-0 py-1 d-flex flex-row'>
                    <Col xs={6} className='m-0 p-0 d-flex flex-column justify-content-center'>
                      <p className='m-0 p-0 px-2 fs-6 text-end'>Email:</p>
                    </Col>
                    <Col xs={6} className='m-0 p-0 d-flex flex-column justify-content-center'>
                      <p className='m-0 p-0 px-2 fs-6 text-start'>{informasiUser.email}</p>
                    </Col>
                  </Row>
                  <Row className='m-0 p-0 py-1 d-flex flex-row'>
                    <Col xs={6} className='m-0 p-0 d-flex flex-column justify-content-center'>
                      <p className='m-0 p-0 px-2 fs-6 text-end'>Tanggal bergabung:</p>
                    </Col>
                    <Col xs={6} className='m-0 p-0 d-flex flex-column justify-content-center'>
                      <p className='m-0 p-0 px-2 fs-6 text-start'>{informasiUser.tanggal_bergabung}</p>
                    </Col>
                  </Row>
                  {idUser == informasiUser.id_user &&
                    <Col xs={12} className='m-0 p-0 py-4 d-flex justify-content-center'>
                      <Col xs={6} className='m-0 p-0 d-flex flex-column'>
                        <Button variant='light' className='border border-dark rounded-pill' onClick={simpanDataUser}>
                          Edit Informasi
                        </Button>
                      </Col>
                    </Col>
                  }
                </Row>
              </Col>
              <Col xs={12} sm={12} md={12} lg={8} xl={8} className='m-0 p-0'>
                <Row className='m-0 p-0 flex-column justify-content-center'>
                  <Row className='m-0 p-0 py-1 d-flex flex-row'>
                    <p className='m-0 p-0 px-2 fs-5 fw-bold text-center'>Aktivitas</p>
                    {frekuensiAktivitas != null &&
                      <CalendarHeatmap
                        startDate={frekuensiAktivitas.tanggalSelesai}
                        endDate={frekuensiAktivitas.tanggalMulai}
                        values={frekuensiAktivitas.aktivitas}
                        titleForValue={(value) => {
                          let frek = 0;
                          let tanggal = "";
                          if (value != null) {
                            frek = value.count;
                            tanggal = value.date;
                          }
                          return `Aktivitas ${tanggal} : ${frek}`
                        }}
                      />
                    }
                  </Row>
                  <Col xs={12}>
                    <p className='text-center fs-3 fw-bold'>History Pengerjaan</p>
                  </Col>
                  <Table bordered hover>
                    <thead>
                      <tr>
                        <th className='text-center fs-6 fw-normal col-2'>Judul Soal</th>
                        <th className='text-center fs-6 fw-normal col-2'>Bahasa</th>
                        <th className='text-center fs-6 fw-normal col-2'>Hasil</th>
                        <th className='text-center fs-6 fw-normal col-2'>Total Waktu</th>
                        <th className='text-center fs-6 fw-normal col-2'>Total Memori</th>
                        <th className='text-center fs-6 fw-normal col-2'>Tanggal Submit</th>
                      </tr>
                    </thead>
                    <tbody>
                      {historyPengerjaan != null && historyPengerjaan.history.map((value : ResponsePengerjaanLama) =>
                        (<tr key={value.id_pengerjaan} onClick={() => {navigate(`/pengerjaan/${value.id_pengerjaan}`)}}>
                          <td className='fs-6 fw-normal text-center' onClick={() => {navigate(`/soal/${value.id_soal}/pengerjaan`)}}>{value.judul_soal}</td>
                          <td className='fs-6 fw-normal text-center'>{value.bahasa}</td>
                          <td className='fs-6 fw-normal text-center'>{value.hasil + (value.outdated ? "[outdated]" : "")}</td>
                          <td className='fs-6 fw-normal text-center'>{value.total_waktu}</td>
                          <td className='fs-6 fw-normal text-center'>{value.total_memori}</td>
                          <td className='fs-6 fw-normal text-center'>{value.tanggal_submit}</td>
                        </tr>)
                      )}
                    </tbody>
                  </Table>
                  {arrayHalaman.map((h : number) => 
                    (<Col className='p-0 m-0' xs={1} key={h}>    
                      <Button variant={h == ambilHistoryPengerjaan.halaman ? 'light' : 'dark'} className='border border-dark' onClick={() => {
                        let halamanSebelumnya = ambilHistoryPengerjaan.halaman;
                        if (h != halamanSebelumnya) {
                          setAmbilHistoryPengerjaan({...ambilHistoryPengerjaan, halaman: h})
                        }
                      }}>
                        {h}
                      </Button>
                    </Col>)
                  )}
                </Row>
              </Col>
            </Row>
          </Row>
        </Col>
      </Container>
    </>
  )
}

export default HalamanInformasiUser
