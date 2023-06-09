import { useState } from 'react'
import { Container, Col, Row, Form, FormGroup, Button, Alert } from 'react-bootstrap'
import ModelAkunRegister from '../../model/Autentikasi/ModelAkunRegister'
import { Link, useNavigate } from 'react-router-dom'
import AkunRegister from '../../core/Autentikasi/Data/AkunRegister'
import BerhasilDaftar from '../../core/Responses/ResponseBerhasil/Autentikasi/BerhasilDaftar'
import KesalahanInputData from '../../core/Responses/ResponseGagal/KesalahanInputData'
import RequestDaftar from '../../core/Autentikasi/RequestDaftar'

function HalamanDaftar() {

  const navigate = useNavigate()

  const [pesanErrorDaftar, setPesanErrorDaftar] = useState<string|null>(null)

  const [dataAkunRegister, setDataAkunRegister] = useState<ModelAkunRegister>({
    nama : "",
    email : "",
    password : "",
    ulangi_password : ""
  })

  let requestDaftar = new RequestDaftar()

  const penangananMasuk = (hasil : any) => {
    if (hasil instanceof BerhasilDaftar) {
      navigate("/")
    }
    else if (hasil instanceof KesalahanInputData) {
      setPesanErrorDaftar(hasil.pesan)
    }
  }

  const submitDaftar = (e : React.FormEvent<HTMLFormElement>) => {
    e.preventDefault()

    requestDaftar.execute(
      {
        nama: dataAkunRegister.nama, 
        email: dataAkunRegister.email, 
        password: dataAkunRegister.password, 
        ulangi_password: dataAkunRegister.ulangi_password
      } as AkunRegister, 
      penangananMasuk
    )
  }

  
  return (
    <>
      <Container className='min-vh-100 mw-100 m-0 p-0 d-flex flex-column'>
        <p className='text-center fs-5 m-0 mt-4'>Hakim Daring</p>
        <Col className='h-100 d-flex flex-column justify-content-center'>
          <Row className='m-0 pb-5 p-0'>
            <Col xs={12} className='d-flex flex-row justify-content-center'>
              <Col xs={8} sm={8} md={6} lg={4} xl={3} className=''>
                <Row className='m-0 p-2'>
                  <p className='text-center fs-2 fw-bold m-0'>Daftar</p>
                  {pesanErrorDaftar != null && 
                    <Alert variant="danger" onClose={() => {setPesanErrorDaftar(null)}} dismissible>
                      <p>
                        {pesanErrorDaftar}
                      </p>
                    </Alert>
                  }
                  <Form onSubmit={submitDaftar}>
                    <FormGroup className='py-2'>
                      <Form.Label>Nama</Form.Label>
                      <Form.Control type='text' placeholder='Masukkan nama anda' onChange={(e) => setDataAkunRegister({...dataAkunRegister, nama : e.target.value})} />
                    </FormGroup>
                    <FormGroup className='py-2'>
                      <Form.Label>Email</Form.Label>
                      <Form.Control type='email' placeholder='Masukkan email anda' onChange={(e) => setDataAkunRegister({...dataAkunRegister, email : e.target.value})} />
                    </FormGroup>
                    <FormGroup className='py-2'>
                      <Form.Label>Password</Form.Label>
                      <Form.Control type='password' placeholder='Masukkan password anda' onChange={(e) => setDataAkunRegister({...dataAkunRegister, password : e.target.value})} />
                    </FormGroup>
                    <FormGroup className='py-2'>
                      <Form.Label>Ulangi Password</Form.Label>
                      <Form.Control type='password' placeholder='Ulangi masukkan password anda' onChange={(e) => setDataAkunRegister({...dataAkunRegister, ulangi_password : e.target.value})} />
                    </FormGroup>
                    <Col className='d-flex flex-row justify-content-center pt-4 pb-5'>
                      <Button variant='dark' type='submit' className='px-4 rounded-pill fs-5'>Daftar</Button>
                    </Col>
                  </Form>
                  <Link to="/" className='text-secondary'>&#8592; Kembali</Link>
                </Row>
              </Col>
            </Col>
          </Row>
        </Col>
      </Container>
    </>
  )
}

export default HalamanDaftar