using Microsoft.AspNetCore.Mvc;
using WebApp.Services;

namespace WebApp { 

    public class ContactData
{
        public string Nom { get; set; }
        public string Email { get; set; }
        public string Message { get; set; }
    }


    public class ContactController : Controller
    {
        private readonly IEmailService _emailService;

        public ContactController(IEmailService emailService)
        {
            _emailService = emailService;
        }

        [HttpPost]
        [Route("/FormController/Submit")]
        public async Task<IActionResult> Submit(string nom, string email, string message)
        {
            // Traitement des données du formulaire...

            // Envoi de l'email
            await _emailService.SendEmailAsync("bontahzno@gmail.com", nom, message);

            // Redirection vers une page de confirmation
            return RedirectToAction("Confirmation");
        }

        public IActionResult Confirmation()
        {
            // Afficher une page de confirmation
            return View();
        }
    }

}
