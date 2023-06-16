import { useState } from 'react'
import { Container, Col, Row, Form, FormGroup, Button } from 'react-bootstrap'
import { useNavigate } from 'react-router-dom'
import ModelAkunLogin from '../../model/Autentikasi/ModelAkunLogin'
import { Link } from 'react-router-dom'
import RequestMasuk from '../../core/Autentikasi/RequestMasuk'
import BerhasilMasuk from '../../core/Responses/ResponseBerhasil/Autentikasi/BerhasilMasuk'
import AkunLogin from '../../core/Autentikasi/Data/AkunLogin'

function HalamanMasuk() {

  const navigate = useNavigate()

  const [dataAkun, setDataAkun] = useState<ModelAkunLogin>({
    email : "",
    password : ""
  })

  let requestMasuk = new RequestMasuk()

  const pindahHalamanJelajah = () => {
    navigate("/jelajah")
  }

  const penangananMasuk = (hasil : any) => {
    if (hasil instanceof BerhasilMasuk) {
      pindahHalamanJelajah()
    }
  }
  

  const submitMasuk = (e : React.FormEvent<HTMLFormElement>) => {
    e.preventDefault()

    requestMasuk.execute({email: dataAkun.email, password: dataAkun.password} as AkunLogin, penangananMasuk)
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
                  <p className='text-center fs-2 fw-bold m-0'>Masuk</p>
                  <Form onSubmit={submitMasuk}>
                    <FormGroup className='py-2'>
                      <Form.Label>Email</Form.Label>
                      <Form.Control type='email' placeholder='Masukkan email anda' onChange={(e) => setDataAkun({...dataAkun, email : e.target.value})} />
                    </FormGroup>
                    <FormGroup className='py-2'>
                      <Form.Label>Password</Form.Label>
                      <Form.Control type='password' placeholder='Masukkan password anda' onChange={(e) => setDataAkun({...dataAkun, password : e.target.value})} />
                    </FormGroup>
                    <Col className='d-flex flex-row justify-content-center pt-4 pb-5'>
                      <Button variant='dark' type='submit' className='px-4 rounded-pill fs-5'>Masuk</Button>
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

export default HalamanMasuk