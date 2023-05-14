import { useEffect, useState } from 'react'
import { Button, Container, Row, Col, Table, Form } from 'react-bootstrap'
import { useNavigate } from 'react-router-dom';
import InterfaceCekMemilikiTokenAutentikasi from '../core/Autentikasi/Interface/InterfaceCekMemilikiTokenAutentikasi';
import CekMemilikiTokenAutentikasi from '../core/Autentikasi/CekMemilikiTokenAutentikasi';
import Header from './Header';
import DaftarSoal from '../core/Data/DaftarSoal';
import InterfacePencarianSoal from '../core/Pencarian/Interface/InterfacePencarianSoal';
import PencarianSoal from '../core/Pencarian/PencarianSoal';
import KategoriPencarian from '../core/Data/KategoriPencarian';

function HalamanJelajah() {

  const navigate = useNavigate()

  let [memilikiToken, setMemilikiToken] = useState<boolean>(false)
  let [halaman, setHalaman] = useState<number>(1)
  let [daftarSoal, setDaftarSoal] = useState<DaftarSoal[]>([])
  let [kategoriPencarian, setKategoriPencarian] = useState<KategoriPencarian>(new KategoriPencarian("", "id_soal", false))

  const cekMemilikiToken : InterfaceCekMemilikiTokenAutentikasi = new CekMemilikiTokenAutentikasi()
  const pencarianSoal : InterfacePencarianSoal = new PencarianSoal()

  function lakukanPencarian() {
    pencarianSoal.cariSoal(kategoriPencarian, halaman, (hasil : any) => {
      if (Array.isArray(hasil)) {
        setDaftarSoal(hasil as DaftarSoal[])
      }
    })
  }

  useEffect(() => {
    if (cekMemilikiToken.cekApakahMemilikiTokenAutentikasi()) {
      setMemilikiToken(true)
    }
    lakukanPencarian()
  }, []) 

  return (
    <>
      <Container className='min-vh-100 min-vw-100 m-0 p-0 d-flex flex-column'>
        <Header />
        <Col className='h-100 justify-content-center'>
          <Row className='m-0 p-0'>
            <p className='text-center m-0 py-3 fs-3 fw-bold mb-3'>
              Jelajah
            </p>
            <Row className='m-0 p-0 d-flex flex-row'>
              <Col xs={12} sm={12} md={12} lg={8} xl={8} className='m-0 p-2'>
                <Row className='m-0 p-0'>
                  <p className='fs-5 fw-bold text-center'>Daftar Soal</p>
                  <Col className='m-0 p-0' xs={12}>
                    <Row className='m-0 p-0 d-flex flex-row'>
                      <Col xs={10}>
                        <Row className='m-0 p-0 d-flex flex-row'>
                          <Col xs={4}>
                            <Form.Control className='my-2 p-1 fs-6 text-center' placeholder='Pencarian dengan judul' value={kategoriPencarian.judul} onChange={(e) => {
                              setKategoriPencarian({...kategoriPencarian, judul : e.target.value})
                            }}/>
                          </Col>
                        </Row>
                      </Col>
                      <Col xs={2} className='d-flex flex-column justify-content-center'>
                        <Button variant='light' className='border border-dark rounded m-0 p-1' onClick={lakukanPencarian}>
                          Cari
                        </Button>
                      </Col>
                    </Row>
                  </Col>
                  <Row className="m-0 p-0 d-flex flex-row">
                    <Table bordered hover>
                      <thead>
                        <tr>
                          <th className='text-center fs-6 fw-normal col-1' onClick={(e) => {
                            if (kategoriPencarian.sortby == "id_soal") {
                              setKategoriPencarian({...kategoriPencarian, sortbyReverse : !kategoriPencarian.sortbyReverse})
                            }
                            else {
                              setKategoriPencarian({...kategoriPencarian, sortby : "id_soal", sortbyReverse : false})
                            }
                            setHalaman(1)
                            lakukanPencarian()
                          }}>ID {kategoriPencarian.sortby == "id_soal" ? (kategoriPencarian.sortbyReverse ? "v" : "^") : ""}</th>
                          <th className='text-center fs-6 fw-normal col-8' onClick={(e) => {
                            if (kategoriPencarian.sortby == "judul") {
                              setKategoriPencarian({...kategoriPencarian, sortbyReverse : !kategoriPencarian.sortbyReverse})
                            }
                            else {
                              setKategoriPencarian({...kategoriPencarian, sortby : "judul", sortbyReverse : false})
                            }
                            setHalaman(1)
                            lakukanPencarian()
                          }}>Judul {kategoriPencarian.sortby == "judul" ? (kategoriPencarian.sortbyReverse ? "v" : "^") : ""}</th>
                          <th className='text-center fs-6 fw-normal col-1' onClick={(e) => {
                            if (kategoriPencarian.sortby == "jumlah_submit") {
                              setKategoriPencarian({...kategoriPencarian, sortbyReverse : !kategoriPencarian.sortbyReverse})
                            }
                            else {
                              setKategoriPencarian({...kategoriPencarian, sortby : "jumlah_submit", sortbyReverse : false})
                            }
                            setHalaman(1)
                            lakukanPencarian()
                          }}>Submit {kategoriPencarian.sortby == "jumlah_submit" ? (kategoriPencarian.sortbyReverse ? "v" : "^") : ""}</th>
                          <th className='text-center fs-6 fw-normal col-1' onClick={(e) => {
                            if (kategoriPencarian.sortby == "jumlah_berhasil") {
                              setKategoriPencarian({...kategoriPencarian, sortbyReverse : !kategoriPencarian.sortbyReverse})
                            }
                            else {
                              setKategoriPencarian({...kategoriPencarian, sortby : "jumlah_berhasil", sortbyReverse : false})
                            }
                            setHalaman(1)
                            lakukanPencarian()
                          }}>Berhasil {kategoriPencarian.sortby == "jumlah_berhasil" ? (kategoriPencarian.sortbyReverse ? "v" : "^") : ""}</th>
                          <th className='text-center fs-6 fw-normal col-1' onClick={(e) => {
                            if (kategoriPencarian.sortby == "persentase_berhasil") {
                              setKategoriPencarian({...kategoriPencarian, sortbyReverse : !kategoriPencarian.sortbyReverse})
                            }
                            else {
                              setKategoriPencarian({...kategoriPencarian, sortby : "persentase_berhasil", sortbyReverse : false})
                            }
                            setHalaman(1)
                            lakukanPencarian()
                          }}>Persentase {kategoriPencarian.sortby == "persentase_berhasil" ? (kategoriPencarian.sortbyReverse ? "v" : "^") : ""}</th>
                        </tr>
                      </thead>
                      <tbody>
                        {daftarSoal.map((value: DaftarSoal, index: number) =>
                          (<tr key={"soal: " + index}>
                            <td className='fs-6 fw-normal text-center'>{value.idSoal.id}</td>
                            <td className='fs-6 fw-normal text-start'>{value.judul}</td>
                            <td className='fs-6 fw-normal text-center'>{value.jumlahSubmit}</td>
                            <td className='fs-6 fw-normal text-center'>{value.berhasilSubmit}</td>
                            <td className='fs-6 fw-normal text-center'>{value.persentaseBerhasil}</td>
                          </tr>)
                        )}
                      </tbody>
                    </Table>
                  </Row>
                </Row>
              </Col>
              <Col xs={12} sm={12} md={12} lg={4} xl={4}>
              </Col>
            </Row>
          </Row>
        </Col>
      </Container>
    </>
  )
}

export default HalamanJelajah
