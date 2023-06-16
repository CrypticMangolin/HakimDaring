import { useState, useEffect } from 'react'
import {Button, Col, Container, Row} from 'react-bootstrap'
import { useNavigate, useParams } from 'react-router-dom'
import Header from '../Header'
import RequestAmbilDaftarPengerjaan from '../../core/Pengerjaan/RequestAmbilDaftarPengerjaan'
import BerhasilAmbilDaftarPengerjaan from '../../core/Responses/ResponseBerhasil/Pengerjaan/BerhasilAmbilDaftarPengerjaan'

function HalamanDaftarpengerjaan() {

  let navigate = useNavigate()
  const parameterURL = useParams()

  const requestAmbilDaftarPengerjaan : RequestAmbilDaftarPengerjaan = new RequestAmbilDaftarPengerjaan()

  const pindahHalamanJelajah = () => {
    navigate("/jelajah")
  }

  const pindahHalamanPengerjaan = () => {
    navigate(`/soal/${parameterURL.id_soal}/pengerjaan`)
  }

  const pindahHalamanDiskusi = () => {
    navigate(`/soal/${parameterURL.id_soal}/diskusi`)
  }

  let [daftarPengerjaan, setDaftarPengerjaan] = useState<BerhasilAmbilDaftarPengerjaan[]>([])

  useEffect(() => {
    if (parameterURL.id_soal === undefined) {
      pindahHalamanJelajah()
    }
    requestAmbilDaftarPengerjaan.execute(parameterURL.id_soal!, (hasil : any) => {
      if (Array.isArray(hasil)) {
        setDaftarPengerjaan(hasil)
      }
      else {
        window.location.reload()
      }
    })
  }, [])

  return (
    <>
      <Container className='min-vh-100 mw-100 m-0 p-0 d-flex flex-column'>
        <Header />
        <Row className='m-0 mb-2 p-0 d-flex flex-row justify-content-start'>
          <Col className='m-0 p-0 d-flex flex-row justify-content-center' xs={1} onClick={pindahHalamanPengerjaan}>
            <Button variant='light' className='m-0 w-100 rounded-0 text-center'>
              Pengerjaan
            </Button>
          </Col>
          <Col className='m-0 p-0 d-flex flex-row justify-content-center' xs={1} onClick={pindahHalamanDiskusi}>
            <Button variant='light' className='m-0 w-100 rounded-0 text-center'>
              Diskusi
            </Button>
          </Col>
          <Col className='m-0 p-0 d-flex flex-row justify-content-center' xs={1}>
            <Button variant='dark' className='m-0 w-100 rounded-0 text-center'>
              Submission
            </Button>
          </Col>
          <hr className='m-0 p-0'></hr>
        </Row>
        <Col xs={12} className='m-0 p-0 d-flex justify-content-center'>
          <Col xs={12} sm={12} md={8} lg={6} xl={6} className='m-0 p-0'>
            <Row className='m-0 p-0 d-flex flex-column'>
              <p className='m-0 py-4 fs-5 fw-bold text-center'>Hasil Submission</p>
              {daftarPengerjaan.map((value : BerhasilAmbilDaftarPengerjaan, index : number) => (
                <>
                  
                </>
              ))}
            </Row>
          </Col>
        </Col>
      </Container>
    </>
  )
}

export default HalamanDaftarpengerjaan