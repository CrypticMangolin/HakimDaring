import { useEffect, useState } from 'react'
import { Container, Col, Row, Form, Button } from 'react-bootstrap'
import Header from './Header'
import { useNavigate, useParams } from 'react-router-dom'
import InterfaceAmbilInformasiSoal from '../core/Soal/Interface/InterfaceAmbilInformasiSoal'
import AmbilInformasiSoal from '../core/Soal/AmbilInformasiSoal'
import IDSoal from '../core/Data/IDSoal'
import InformasiSoal from '../core/Data/InformasiSoal'
import AceEditor from 'react-ace'

import "ace-builds/src-noconflict/theme-iplastic"
import "ace-builds/src-noconflict/ext-language_tools"
import InterfaceDaftarBahasa from '../core/Pengerjaan/Interface/InterfaceDaftarBahasa'
import DaftarBahasa from '../core/Pengerjaan/DaftarBahasa'
import BahasaPemrograman from '../core/Data/BahasaPemrograman'
import BerhasilUjiCobaProgram from '../core/Data/ResponseBerhasil/BerhasilUjiCobaProgram'
import InterfaceKirimUjiCobaProgram from '../core/Pengerjaan/Interface/InterfaceKirimUjiCobaProgram'
import KirimUjiCobaProgram from '../core/Pengerjaan/KirimUjiCobaProgram'
import UjiCoba from '../core/Data/UjiCoba'
import ContohInput from '../core/Data/ContohInput'
import InterfaceAmbilTestcasePublik from '../core/Pengerjaan/Interface/InterfaceAmbilTestcasePublik'
import AmbilTestcasePublik from '../core/Pengerjaan/AmbilTestcasePublik'
import CekMemilikiTokenAutentikasi from '../core/Autentikasi/CekMemilikiTokenAutentikasi'
import InterfaceCekMemilikiTokenAutentikasi from '../core/Autentikasi/Interface/InterfaceCekMemilikiTokenAutentikasi'
import InterfaceKirimPengerjaan from '../core/Pengerjaan/Interface/InterfaceKirimPengerjaan'
import KirimPengerjaan from '../core/Pengerjaan/KirimPengerjaan'
import SubmitPengerjaan from '../core/Data/SubmitPengerjaan'

function HalamanPengerjaan() {

  const navigate = useNavigate()
  const parameterURL = useParams()
  let [informasiSoal, setInformasiSoal] = useState<InformasiSoal|null>(null)

  const pindahHalamanJelajah = () => {
    navigate("/jelajah")
  }

  const pindahHalamanDiskusi = () => {
    navigate(`/soal/${parameterURL.id_soal}/diskusi`)
  }

  const pindahHalamanHasil = () => {
    navigate(`/soal/${parameterURL.id_soal}/hasil`)
  }

  const pindahHalamanMasuk = () => {
    navigate("/masuk")
  }

  const ambilInformasiSoal : InterfaceAmbilInformasiSoal = new AmbilInformasiSoal()
  const daftarBahasa : InterfaceDaftarBahasa = new DaftarBahasa()
  const kirimUjiCobaProgram : InterfaceKirimUjiCobaProgram = new KirimUjiCobaProgram()
  const ambilTestcasePublik : InterfaceAmbilTestcasePublik = new AmbilTestcasePublik()
  const cekAutentikasi : InterfaceCekMemilikiTokenAutentikasi = new CekMemilikiTokenAutentikasi()
  const kirimPengerjaan : InterfaceKirimPengerjaan = new KirimPengerjaan()

  let [daftarModeBahasa, ] = useState<BahasaPemrograman[]>(daftarBahasa.ambilBahasa())
  let [bahasaDipilih, setBahasaDipilih] = useState<number>(0)
  let [inputCustom, setInputCustom] = useState<string[]>([])
  let [hasilUjiCoba, setHasilUjiCoba] = useState<(BerhasilUjiCobaProgram|null)[]>([])
  let [sourceCode, setSourceCode] = useState<string>("")
  let [daftarContohInput, setDaftarContohInput] = useState<ContohInput[]>([])
  let [telahLogin, setTelahLogin] =  useState<boolean>(false)


  const pilihBahasa = (e : any) => {
    setBahasaDipilih(e.target.value)
  }

  const perubahanSourceCode = (code : string) => {
    setSourceCode(code)
  }

  const tambahCustomInput = () => {
    if (inputCustom.length < 6) {
      setInputCustom([...inputCustom, ""])
      setHasilUjiCoba([...hasilUjiCoba, null])
    }
  }

  const hapusCostumInput = (index : number) => {
    let inputCustomBaru = [...inputCustom]
    inputCustomBaru.splice(index, 1)
    setInputCustom(inputCustomBaru)

    let hasilUjiCobaBaru = [...hasilUjiCoba]
    hasilUjiCobaBaru.splice(index, 1)
    setHasilUjiCoba(hasilUjiCobaBaru)
  }

  const gantiCostumInput = (index : number, input : string) => {
    let inputCustomBaru = [...inputCustom]
    inputCustomBaru[index] = input
    setInputCustom(inputCustomBaru)
  }

  const runUjiCobaProgram = () => {
    kirimUjiCobaProgram.kirimUjiCoba(new UjiCoba(
      new IDSoal(Number(parameterURL.id_soal)),
      sourceCode,
      daftarModeBahasa[bahasaDipilih].bahasa,
      inputCustom
    ), (hasil : any) => {
      if (Array.isArray(hasil)) {
        setHasilUjiCoba(hasil)
      }
    })
  }

  const submitPengerjaan = () => {
    kirimPengerjaan.kirimPengerjaanProgram(new SubmitPengerjaan(
      new IDSoal(Number(parameterURL.id_soal)),
      sourceCode,
      daftarModeBahasa[bahasaDipilih].bahasa,
    ), (hasil : any) => {
      console.log(hasil)
    })
  }
  
  useEffect(() => {
    setTelahLogin(cekAutentikasi.cekApakahMemilikiTokenAutentikasi())

    if (parameterURL.id_soal != null && !Number.isNaN(Number(parameterURL.id_soal))) {
      ambilInformasiSoal.ambilInformasiSoal(new IDSoal(Number(parameterURL.id_soal)), (hasil : any) => {
        if (hasil instanceof InformasiSoal) {
          setInformasiSoal(hasil)
        }
        else {
          pindahHalamanJelajah()
        }
      })

      ambilTestcasePublik.ambilTestcase(new IDSoal(Number(parameterURL.id_soal)), (hasil : any) => {
        if (Array.isArray(hasil)) {
          setDaftarContohInput(hasil)
        }
        else {
          pindahHalamanJelajah()
        }
      })
    }
    else {
      pindahHalamanJelajah()
    }

  }, [])

  return (
  <>
    <Container className='min-vh-100 mw-100 m-0 p-0 d-flex flex-column'>
      <Header />
      <Row className='m-0 mb-2 p-0 d-flex flex-row justify-content-start'>
        <Col className='m-0 p-0 d-flex flex-row justify-content-center' xs={1}>
          <Button variant='dark' className='m-0 w-100 rounded-0 text-center'>
            Pengerjaan
          </Button>
        </Col>
        <Col className='m-0 p-0 d-flex flex-row justify-content-center' xs={1} onClick={pindahHalamanDiskusi}>
          <Button variant='light' className='m-0 w-100 rounded-0 text-center'>
            Diskusi
          </Button>
        </Col>
        <Col className='m-0 p-0 d-flex flex-row justify-content-center' xs={1} onClick={pindahHalamanHasil}>
          <Button variant='light' className='m-0 w-100 rounded-0 text-center'>
            Submission
          </Button>
        </Col>
        <hr className='m-0 p-0'></hr>
      </Row>
      <Row className='m-0 p-0'>
        <Col sm={12} md={12} lg={6} xl={6} className="d-flex flex-column m-0 p-2">
          <Row className='m-0 p-0 px-4 d-flex flex-column'>
            <Col className='m-0 p-0'>
              <Row className='m-0 mb-4 px-5 p-0 d-flex flex-column'>
                <p className='m-0 py-2 fs-4 fw-bold text-center'>{informasiSoal?.judul}</p>
              </Row>
            </Col>
            <Col className='m-0 mb-2 p-0'>
              <Col className='m-2 p-0' dangerouslySetInnerHTML={{ __html: informasiSoal != null ? informasiSoal.soal : "" }}>
              </Col>
            </Col>
            <Col className='m-0 p-0'>
              <Row className='m-0 p-0 d-flex flex-column'>
                <p className="m-0 mb-1 p-0 fs-5 fw-bold">Batasan Soal</p>
                <Row className='m-0 p-0 d-flex flex-row'>
                  <Col xs={4} className='m-0 p-0'>
                    <p className='m-0 p-0 fs-6'>Waktu per testcase</p>
                  </Col>
                  <Col xs={8} className='m-0 p-0'>
                    <p className='m-0 p-0 fs-6'>: <b>{informasiSoal?.batasanWaktuPerTestcase}</b> sekon</p>
                  </Col>
                </Row>
                <Row className='m-0 p-0 d-flex flex-row'>
                  <Col xs={4} className='m-0 p-0'>
                    <p className='m-0 p-0 fs-6'>Waktu total</p>
                  </Col>
                  <Col xs={8} className='m-0 p-0'>
                    <p className='m-0 p-0 fs-6'>: <b>{informasiSoal?.batasanWaktuTotal}</b> sekon</p>
                  </Col>
                </Row>
                <Row className='m-0 p-0 d-flex flex-row'>
                  <Col xs={4} className='m-0 p-0'>
                    <p className='m-0 p-0 fs-6'>Batasan memori</p>
                  </Col>
                  <Col xs={8} className='m-0 p-0'>
                    <p className='m-0 p-0 fs-6'>: <b>{informasiSoal?.batasanMemoriDalamKB}</b> KB</p>
                  </Col>
                </Row>
              </Row>
            </Col>
            <Col className='m-0 p-0 py-4'>
              <Row className='m-0 p-0 d-flex flex-column'>
                <p className='m-0 p-0 fs-5 fw-bold text-start'>Contoh Input</p>
                {daftarContohInput.map((value : ContohInput, index : number) => {
                  return (
                    <Row className='m-0 p-0 py-2 d-flex flex-column' key={index}>
                      <p className='m-0 p-0 fs-6'>Input {index + 1}</p>
                      <textarea rows={3} className='m-0 p-0 pb-2' readOnly value={value.testcase} style={{resize: 'none'}}/>
                      <p className='m-0 p-0 fs-6'>Output {index + 1}</p>
                      <textarea rows={3} className='m-0 p-0 pb-2' readOnly value={value.jawaban} style={{resize: 'none'}}/>
                    </Row>
                  )
                })}
              </Row>
            </Col>
          </Row>
        </Col>
        <Col sm={12} md={12} lg={6} xl={6} className="d-flex flex-column m-0 p-2">
          <Row className='m-0 p-0 d-flex flex-column'>
            <Row className='m-0 mb-2 p-0 d-flex flex-row'>
              <Col xs={2} className='m-0 p-0'>
                <Form.Select size='sm' value={daftarModeBahasa.length > 0 ? bahasaDipilih : ""} onChange={pilihBahasa}>
                  {daftarModeBahasa.map((value : BahasaPemrograman, index : number) => (
                    <option key={index} value={index}>{value.bahasa}</option>
                  ))}
                </Form.Select>
              </Col>
            </Row>
            <AceEditor
              placeholder="Placeholder Text"
              mode={daftarModeBahasa[bahasaDipilih].mode}
              theme="iplastic"
              fontSize={14}
              showPrintMargin={true}
              showGutter={true}
              highlightActiveLine={true}
              width='100vw'
              value={sourceCode}
              onChange={perubahanSourceCode}
              setOptions={{
                enableBasicAutocompletion: true,
                enableLiveAutocompletion: true,
                enableSnippets: false,
                showLineNumbers: true,
                tabSize: 4,
              }}/>
            {
              telahLogin &&
              <>
                <p className='m-0 p-0 my-2 text-center fs-5 fw-bold'>Custom Test</p>
                <Row className='m-0 p-0 d-flex flex-column' xs={12}>
                  {inputCustom.map((value : string, index : number) => (
                    <Row key={index} className='m-0 p-0 d-flex flex-row mb-1' xs={12}>
                      <Col xs={1} className='m-0 p-0 justify-content-center'>
                        <Button variant="light" className="w-100 h-100 m-0 rounded-0 border border-dark" onClick={() => {hapusCostumInput(index)}}>X</Button>
                      </Col>
                      <Col xs={5} className='m-0 p-0'>
                        <textarea className='m-0 w-100 h-100' rows={3} placeholder='Masukkan input' style={{"resize" : "none"}} onChange={(e) => {gantiCostumInput(index, e.target.value)}} value={value}/>
                      </Col>
                      <Col xs={5} className='m-0 p-0'>
                        <textarea className='m-0 w-100 h-100' readOnly rows={3} style={{"resize" : "none"}} value={hasilUjiCoba[index]?.stdout}/>
                      </Col>
                    </Row>
                  ))}
                  <Row className='m-0 p-0 d-flex flex-row'>
                    {
                      inputCustom.length < 6 && 
                      <Col className='m-0 mb-1 p-0' xs={4}>
                        <Button variant='light' className='btn-block m-0 rounded-0 border border-dark' onClick={tambahCustomInput}>Tambah testcase +</Button>
                      </Col>
                    }
                    <Col className='m-0 mb-1 p-0' xs={4}>
                      <Button variant='light' className='btn-block m-0 rounded-0 border border-dark' onClick={runUjiCobaProgram}>Run Testcase</Button>
                    </Col>
                    <Col className='m-0 mb-1 p-0' xs={4}>
                      <Button variant='light' className='btn-block m-0 rounded-0 border border-dark' onClick={submitPengerjaan}>Submit</Button>
                    </Col>
                  </Row>
                </Row>
              </>
            }
            {
              !telahLogin &&
              <Col className='m-0 p-0 py-2 d-flex justify-content-center'>
                <Button variant='dark' className='m-0 fs-6' onClick={pindahHalamanMasuk}>
                  Masuk untuk mengerjakan soal
                </Button>
              </Col>
            }
          </Row>
        </Col>
      </Row>
    </Container>
  </>)
}

export default HalamanPengerjaan