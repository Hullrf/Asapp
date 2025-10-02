import React, { useState } from "react";
import LOGOA2 from "./LOGO-a-2.png";
import { MenuBook } from "./MenuBook";
import bannerAds from "./banner-ads.svg";
import border from "./border.svg";
import image1 from "./image.png";
import image from "./image.svg";
import rectangle from "./rectangle.svg";

export const FooterSection = (): JSX.Element => {
  const [email, setEmail] = useState("");

  const companyLinks = [
    { text: "Servicios", href: "#" },
    { text: "Términos del sitio web", href: "#" },
    { text: "Convertidor de divisas", href: "#" },
    { text: "Colabora con nosotros", href: "#" },
    { text: "Prensa & Medios", href: "#" },
  ];

  const contactInfo = [
    { text: "Av. El Dorado #69-76 Torre 1, Bogotá" },
    { text: "Telefono:+57 (601) 220 2880" },
    { text: "Email: ASAPPsupport@ASAPP.com" },
  ];

  const socialIcons = [
    { icon: "", href: "#", label: "Facebook" },
    { icon: "", href: "#", label: "Twitter" },
    { icon: "", href: "#", label: "LinkedIn" },
    { icon: "", href: "#", label: "Instagram" },
  ];

  const handleEmailSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    console.log("Email submitted:", email);
  };

  return (
    <footer className="absolute top-[659px] left-1 w-[1280px] h-[652px] bg-[#ffffff] overflow-hidden">
      <img
        className="absolute top-[-2952px] left-[-2875px] w-[1280px] h-10"
        alt="Rectangle"
        src={rectangle}
      />

      <div className="absolute top-[-9px] left-[84px] [font-family:'Roboto-Bold',Helvetica] font-bold text-[#ffffff] text-[13.5px] tracking-[0.25px] leading-8 whitespace-nowrap">
        Portal de residuos
      </div>

      <div className="absolute top-[3px] left-[1064px] [font-family:'Roboto-Bold',Helvetica] font-bold text-[#ffffff] text-base tracking-[0.30px] leading-8 whitespace-nowrap">
        Iniciar sesión
      </div>

      <div className="absolute top-[3px] left-[1176px] [font-family:'Roboto-Bold',Helvetica] font-bold text-[#ffffff] text-base tracking-[0.60px] leading-8 whitespace-nowrap">
        Registrar
      </div>

      <MenuBook className="!absolute !top-0 !left-6 !w-4 !h-3.5" />

      <div className="absolute top-[35px] left-0 w-[1280px] h-[650px] flex bg-[#ffffff] overflow-hidden">
        <img
          className="mt-[-2987px] w-[1280px] h-10 ml-[-2875px]"
          alt="Rectangle"
          src={image}
        />

        <MenuBook className="!ml-[1619px] !w-4 !h-3.5" />
        <div className="mt-[-9px] w-[116px] h-8 ml-11 [font-family:'Roboto-Bold',Helvetica] font-bold text-[#ffffff] text-[13.5px] tracking-[0.25px] leading-8 whitespace-nowrap">
          Portal de residuos
        </div>

        <div className="mt-[3px] w-[101px] h-8 ml-[864px] [font-family:'Roboto-Bold',Helvetica] font-bold text-[#ffffff] text-base tracking-[0.30px] leading-8 whitespace-nowrap">
          Iniciar sesión
        </div>

        <div className="mt-[3px] w-[71px] h-8 ml-[11px] [font-family:'Roboto-Bold',Helvetica] font-bold text-[#ffffff] text-base tracking-[0.60px] leading-8 whitespace-nowrap">
          Registrar
        </div>
      </div>

      <div className="absolute top-px left-0 w-[1280px] h-[618px]">
        <div className="flex flex-col w-full items-start absolute h-[95.50%] top-[10.22%] left-0 bg-dark">
          <img
            className="relative self-stretch w-full h-px mt-[-0.36px]"
            alt="Border"
            src={border}
          />

          <div className="flex flex-col items-center pt-[129.75px] pb-0 px-0 relative self-stretch w-full flex-[0_0_auto] bg-background" />

          <div className="flex h-[141.87px] items-center justify-between px-[71.29px] py-[42.77px] relative self-stretch w-full bg-[#5515c0]">
            <div className="flex flex-col w-[369.29px] items-start gap-[17.11px] relative mt-[-30.40px] mb-[-30.40px]">
              <p className="relative self-stretch mt-[-0.71px] font-heading-6 font-[number:var(--heading-6-font-weight)] text-white text-[length:var(--heading-6-font-size)] tracking-[var(--heading-6-letter-spacing)] leading-[var(--heading-6-line-height)] [font-style:var(--heading-6-font-style)]">
                Regístrate hoy y recibe 10% de descuento en tu primer pago
              </p>

              <p className="relative self-stretch font-body-normal font-[number:var(--body-normal-font-weight)] text-border text-[length:var(--body-normal-font-size)] tracking-[var(--body-normal-letter-spacing)] leading-[var(--body-normal-line-height)] [font-style:var(--body-normal-font-style)]">
                ¡Haz que dividir la cuenta sea más fácil y económico!
              </p>
            </div>

            <div className="flex flex-col w-[318.67px] items-start gap-[11.41px] relative mt-[-27.23px] mb-[-27.23px]">
              <p className="relative self-stretch mt-[-0.71px] font-heading-title font-[number:var(--heading-title-font-weight)] text-border text-[length:var(--heading-title-font-size)] tracking-[var(--heading-title-letter-spacing)] leading-[var(--heading-title-line-height)] [font-style:var(--heading-title-font-style)]">
                Registrate para mantenerte al dia
              </p>

              <form
                onSubmit={handleEmailSubmit}
                className="flex items-center justify-between pl-[17.11px] pr-[2.85px] py-[2.85px] relative self-stretch w-full flex-[0_0_auto] bg-white rounded-[17.11px] overflow-hidden border-[0.71px] border-solid border-white"
              >
                <input
                  type="email"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  placeholder="ingresa tu dirección email"
                  className="[font-family:'Inter-Regular',Helvetica] font-normal text-text text-[11.4px] tracking-[0] leading-[17.1px] bg-transparent border-none outline-none flex-1"
                  required
                />

                <button
                  type="submit"
                  className="all-[unset] box-border gap-[5.7px] px-[17.11px] py-[12.83px] relative flex-[0_0_auto] bg-secondary rounded-[70.58px] inline-flex items-center justify-center overflow-hidden cursor-pointer"
                >
                  <div className="mt-[-0.71px] font-link-normal font-[number:var(--link-normal-font-weight)] text-white text-[length:var(--link-normal-font-size)] tracking-[var(--link-normal-letter-spacing)] leading-[var(--link-normal-line-height)] relative w-fit whitespace-nowrap [font-style:var(--link-normal-font-style)]">
                    SUBSCRIBETE
                  </div>
                </button>
              </form>
            </div>
          </div>

          <div className="flex items-center justify-between px-[71.29px] py-[28.52px] relative self-stretch w-full flex-[0_0_auto] bg-white">
            <p className="relative w-fit mt-[-0.71px] font-body-normal font-[number:var(--body-normal-font-weight)] text-dark text-[length:var(--body-normal-font-size)] text-center tracking-[var(--body-normal-letter-spacing)] leading-[var(--body-normal-line-height)] whitespace-nowrap [font-style:var(--body-normal-font-style)]">
              2025 © ASAPP. All Rights Reserved.
            </p>

            <nav className="inline-flex items-center gap-[17.11px] relative flex-[0_0_auto]">
              <a
                href="#privacy"
                className="relative w-fit mt-[-0.71px] font-body-normal font-[number:var(--body-normal-font-weight)] text-text text-[length:var(--body-normal-font-size)] text-center tracking-[var(--body-normal-letter-spacing)] leading-[var(--body-normal-line-height)] whitespace-nowrap [font-style:var(--body-normal-font-style)] hover:underline"
              >
                Privacidad &amp; Politicas
              </a>

              <a
                href="#terms"
                className="relative w-fit mt-[-0.71px] font-body-normal font-[number:var(--body-normal-font-weight)] text-text text-[length:var(--body-normal-font-size)] text-center tracking-[var(--body-normal-letter-spacing)] leading-[var(--body-normal-line-height)] whitespace-nowrap [font-style:var(--body-normal-font-style)] hover:underline"
              >
                Terminos &amp; Condiciones
              </a>
            </nav>
          </div>
        </div>

        <img
          className="absolute w-[86.77%] h-[28.40%] top-0 left-[6.61%]"
          alt="Banner ads"
          src={bannerAds}
        />
      </div>

      <div className="flex w-[871px] h-4 items-start gap-[22.81px] absolute top-[206px] left-[179px]">
        <div className="flex flex-col w-[198.19px] items-start gap-[22.81px] relative mb-[-105.19px]">
          <div className="inline-flex items-center gap-[7.84px] relative flex-[0_0_auto]">
            <div className="relative w-[21.39px] h-[21.39px] bg-[url(/box.svg)] bg-[100%_100%]" />

            <div className="text-[#5515c0] text-[14.3px] tracking-[1.43px] leading-[17.1px] relative w-fit [font-family:'Inter-Bold',Helvetica] font-bold whitespace-nowrap">
              ASAPP
            </div>
          </div>

          <div className="flex flex-col items-start gap-[22.81px] relative self-stretch w-full flex-[0_0_auto]">
            <p className="relative w-[198.19px] h-[76.99px] mt-[-0.71px] [font-family:'Inter-Regular',Helvetica] font-normal text-text text-[11.4px] tracking-[0] leading-[17.1px]">
              Nuestra plataforma simplifica la forma en que compartes y divides
              gastos, asegurando que cada pago sea justo y transparente. Ya sea
              para un grupo de amigos, un viaje, una salida o cualquier
              actividad en conjunto, disfruta de una experiencia confiable,
              rápida y sin complicaciones.
            </p>
          </div>
        </div>

        <div className="relative w-[128.32px] h-[19px] mb-[-3.00px]" />

        <div className="flex flex-col w-[175.38px] items-start gap-[22.81px] relative mb-[-157.07px]">
          <h3 className="relative w-fit mt-[-0.71px] [font-family:'Inter-SemiBold',Helvetica] font-semibold text-dark text-[12.8px] tracking-[0] leading-[18.5px] whitespace-nowrap">
            EMPRESA
          </h3>

          <nav className="flex flex-col items-start gap-[22.81px] w-full flex-[0_0_auto] relative self-stretch">
            {companyLinks.map((link, index) => (
              <a
                key={index}
                href={link.href}
                className="[font-family:'Inter-Regular',Helvetica] font-normal text-text text-[11.4px] tracking-[0] leading-[17.1px] relative self-stretch hover:text-primary transition-colors"
              >
                {link.text}
              </a>
            ))}
          </nav>
        </div>

        <div className="flex flex-col w-[197.48px] items-start gap-[22.81px] relative mb-[-210.25px]">
          <h3 className="relative w-fit mt-[-0.71px] [font-family:'Inter-SemiBold',Helvetica] font-semibold text-dark text-[12.8px] tracking-[0] leading-[18.5px] whitespace-nowrap">
            CONTACTANOS
          </h3>

          <div className="flex flex-col items-start gap-[22.81px] self-stretch w-full relative flex-[0_0_auto]">
            {contactInfo.map((info, index) => (
              <div
                key={index}
                className="flex items-center gap-[9.98px] self-stretch w-full relative flex-[0_0_auto]"
              >
                <p className="relative flex-1 mt-[-0.71px] [font-family:'Inter-Regular',Helvetica] font-normal text-text text-[11.4px] tracking-[0] leading-[17.1px]">
                  {info.text}
                </p>
              </div>
            ))}

            <div className="inline-flex items-center gap-[22.81px] relative flex-[0_0_auto]">
              {socialIcons.map((social, index) => (
                <a
                  key={index}
                  href={social.href}
                  aria-label={social.label}
                  className="all-[unset] box-border gap-[5.7px] relative flex-[0_0_auto] rounded-[8.55px] shadow-[0px_0.71px_1.43px_#1018280d] inline-flex items-center justify-center overflow-hidden cursor-pointer hover:shadow-md transition-shadow"
                >
                  <div className="mt-[-0.71px] [font-family:'Font_Awesome_6_Brands-Regular',Helvetica] font-normal text-dark text-[17.1px] text-center tracking-[0] leading-[22.8px] relative w-fit whitespace-nowrap">
                    {social.icon}
                  </div>
                </a>
              ))}
            </div>
          </div>
        </div>
      </div>

      <img
        className="absolute top-[186px] left-[168px] w-[45px] h-[55px] aspect-[0.82] object-cover"
        alt="Logo a"
        src={image1}
      />

      <div className="absolute top-[252px] left-[551px] w-32 [font-family:'Inter-Regular',Helvetica] font-normal text-text text-[11.4px] tracking-[0] leading-[17.1px]">
        Servicios
      </div>

      <img
        className="absolute top-[186px] left-[168px] w-[45px] h-[55px] aspect-[0.82] object-cover"
        alt="Logo a"
        src={LOGOA2}
      />

      <p className="absolute top-[684px] left-[769px] [font-family:'Manrope-Bold',Helvetica] font-bold text-black text-[22.8px] text-center tracking-[0] leading-[28.5px] whitespace-nowrap">
        Comienza a dividir tu cuenta
      </p>
    </footer>
  );
};
